
function changeurl(){
    var thisurl;
    $.ajax({
        type:'get',
        url :'/admin/get-purchase-request-root-url',
        async:false,
        success:function(res){
            thisurl=res.url;
            console.log(thisurl)
        }
    });
    return thisurl;
}
