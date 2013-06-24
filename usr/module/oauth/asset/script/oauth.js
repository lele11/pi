
$("#login-btn").click(function(){
    var identity = $("#identity").val();
    var credential = $("#credential").val();
    $.ajax({type:"post",url:"/oauth/authorization/loginAjax",data:{"identity":identity,"credential":credential},success:function(data){
        if(data) {
            // window.location.reload();
            console.log(data);
        }
            
    }});
});
