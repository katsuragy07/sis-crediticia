$(document).ready(inicio);

var headerY = 0;


function inicio(){
    
    var button_responsive = true;
    $("#nav-button-responsive").on("click",()=>{
        if(button_responsive){
            button_responsive = false;
            $(".nav-responsive-cont").css("display","block");
            $(".nav-responsive-cont").on("mouseleave",()=>{
                    button_responsive = true;
                    $(".nav-responsive-cont").css("display","none");   
            });
            $("body").on("mouseenter",()=>{
                button_responsive = true;
                $(".nav-responsive-cont").css("display","none");
            })
        }else{
            button_responsive = true;
            $(".nav-responsive-cont").css("display","none");
        }  
    });

    setInterval(()=>{
        headerY = $("header").height();
        $(".padding-header").css("height",headerY);   
    },100);

}