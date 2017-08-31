<?php

namespace App\Utils;

use App\Models\ClientMovieRequirement;

class SimilarityCaculator
{
    const RANGE_SORT_NUMERIC = 'NUMERIC';
    const RANGE_SORT_DATE    = 'DATE';

    /**
     * Caculate the similarity of two given arrays.
     * The array value should be normalized numeric.
     * @param array $arrayA
     * @param array $arrayB
     * @return int
     */
    public static function arraySimilarity(array $arrayA, array $arrayB)
    {
        $maxArrayLength = count($arrayA) > count($arrayB) ? count($arrayA) : count($arrayB);

        $arrayA = array_pad($arrayA, $maxArrayLength, 0);
        $arrayB = array_pad($arrayB, $maxArrayLength, 0);

        $fenzi              = 0;
        $arrayATotalSquares = 0;
        $arrayBTotalSquares = 0;
        for ($i = 0; $i < $maxArrayLength; $i++) {
            $fenzi              += $arrayA[$i] * $arrayB[$i];
            $arrayATotalSquares += pow($arrayA[$i], 2);
            $arrayBTotalSquares += pow($arrayB[$i], 2);
        }

        $result = ($fenzi) / (sqrt($arrayATotalSquares) * sqrt($arrayBTotalSquares));

        return number_format($result, 2) * 100 . '%';
    }

    /**
     * The range array should have structure : [ bottom , top]
     * @param array  $rangeA
     * @param array  $rangeB
     * @param string $sortFlag
     * @return int
     */
    public static function rangeSimilarity(array $rangeA, array $rangeB, $sortFlag = self::RANGE_SORT_NUMERIC)
    {
        if ($sortFlag == self::RANGE_SORT_DATE) {
            $rangeA = array_map(function ($value) {
                return strtotime($value);
            }, $rangeA);
            $rangeB = array_map(function ($value) {
                return strtotime($value);
            }, $rangeB);
        }

        sort($rangeA);
        sort($rangeB);

        if ($rangeA === $rangeB) {
            return '100%';
        }

        list($minA, $maxA) = $rangeA;
        list($minB, $maxB) = $rangeB;

        //If the two rangs have no interest area, return 0;
        if (($maxA < $minB) || ($minA > $maxB)) {
            return 0;
        }


        if ($minA <= $minB && $maxA >= $minB) {
            $commonArea = $maxB > $maxA ? abs($maxA - $minB) : abs($maxB - $minB);
        }

        if ($minA <= $maxB && $maxA >= $maxB) {
            $commonArea = $minB < $minA ? abs($maxB - $minA) : abs($maxB - $minB);
        }

        $result = ($commonArea * 2) / (($maxB - $minB) + ($maxA - $minA));

        return number_format($result, 2) * 100 . '%';
    }

    /**
     * @param ClientMovieRequirement $client
     * @param ClientMovieRequirement $movie
     * @return string
     */
    public static function clientMovieSimilarity(ClientMovieRequirement $client, ClientMovieRequirement $movie)
    {
        $result = 0;
        $result += floatval(SimilarityCaculator::clientMovieInvestSimilarity($client, $movie)) / 100;
        $result += floatval(SimilarityCaculator::clientMovieInvestSimilarity($client, $movie)) / 100;
        $result += floatval(SimilarityCaculator::clientMovieInvestSimilarity($client, $movie)) / 100;
        $result += floatval(SimilarityCaculator::clientMovieDateSimilarity($client, $movie, self::RANGE_SORT_DATE)) / 100;
        $result += floatval(SimilarityCaculator::clientMovieBudgetSimilarity($client, $movie)) / 100;

        $result = $result / 5;
        return number_format($result, 2) * 100 . '%';
    }

    public static function arraySimilarityOnlyCheckDiff(array $arrayA, array $arrayB)
    {
        if (count(array_intersect_assoc($arrayA, $arrayB))) {
            return '100%';
        }
        return '0%';
    }

    public static function rangeInterested(array $arrayA, array $arrayB)
    {
        sort($arrayA);
        sort($arrayB);

        list($minA, $maxA) = $arrayA;
        list($minB, $maxB) = $arrayB;

        //If the two rangs have no interest area, return 0;
        if (($maxA < $minB) || ($minA > $maxB)) {
            return '0%';
        }

        if ($minA <= $minB && $maxA >= $minB) {
            return '100%';
        }

        if ($minA <= $maxB && $maxA >= $maxB) {
            return '100%';
        }
        return '0%';
    }

    public static function clientMovieInvestSimilarity(ClientMovieRequirement $client, ClientMovieRequirement $movie)
    {
        return self::arraySimilarityOnlyCheckDiff($client->normalizedInvestTypes(), $movie->normalizedInvestTypes());
    }

    public static function clientMovieMovieTypesSimilarity(ClientMovieRequirement $client, ClientMovieRequirement $movie)
    {
        return self::arraySimilarity($client->normalizedMovieTypes(), $movie->normalizedMovieTypes());
    }


    public static function clientMovieRewardSimilarity(ClientMovieRequirement $client, ClientMovieRequirement $movie)
    {
        return self::arraySimilarity($client->normalizedRewardTypes(), $movie->normalizedRewardTypes());
    }

    public static function clientMovieDateSimilarity(ClientMovieRequirement $client, ClientMovieRequirement $movie)
    {
        return self::rangeSimilarity([$client->start_date, $client->end_date], [$movie->start_date, $movie->end_date], self::RANGE_SORT_DATE);
    }

    public static function clientMovieBudgetSimilarity(ClientMovieRequirement $client, ClientMovieRequirement $movie)
    {
        return self::rangeInterested([$client->budget_bottom, $client->budget_top], [$movie->budget_bottom, $movie->budget_top]);
    }


}
