smilies =[
    ":ambivalent:",
    ":angry:",
    ":confused:",
    ":content:",
    ":cool:",
    ":crazy:",
    ":cry:",
    ":embarrassed:",
    ":footinmouth:",
    ":frown:",
    ":gasp:",
    ":grin:",
    ":heart:",
    ":hearteyes:",
    ":innocent:",
    ":kiss:",
    ":laughing:",
    ":minifrown:",
    ":minismile:",
    ":moneymouth:",
    ":naughty:",
    ":nerd:",
    ":notamused:",
    ":sarcastic:",
    ":sealed:",
    ":sick:",
    ":slant:",
    ":smile:",
    ":thumbsdown:",
    ":thumbsup:",
    ":wink:",
    ":yuck:",
    ":yum:"
];

function parseSmilies(text){
    foundSmilies = text.match(/:(.*?):/g);
    if(foundSmilies){
        foundSmilies.forEach(function(smiley){
            if(smilies.indexOf(smiley)!=-1){
                img = "<img src='"+configuration.smileyDir+smiley.substring(1,smiley.length-1)+".png'/>";
                text = text.replace(smiley,img);
            }
        });
    }
            //text.replace(smiley, smiley.substring())
    /*for (var val in smilies)
        text = text.replace(new RegExp(val, "g"), val.substring(1, val.length-1));*/
    return text;
}


$(document).ready(function(){
    $("#tog-smile").click(function(){
        $(".smiley-table").toggleClass('hidden');
    });
    $(".smiley-table li").click(function(){
        img=$(this).find('img').attr('src').split("/");
        smile=" :"+img[img.length-1].split(".")[0]+":";
        chat=$("#chat-text").val();
        $("#chat-text").val(chat+smile).focus();

    })
});