// PAGE TITLE
// var pageTitle = $(document).attr('title');

// SOUND 
var snd = new Audio("sound/msg-sound2.mp3");

function checkMsg() {
    var res = false;
    var numNewMsg = $('#chat-area span').length;
    var lineAuthor = $('#chat-area span').last().text();
    var numMsg = $('#chat-area span').length;

    if (numMsg == numNewMsg && numNewMsg != 0 && name == lineAuthor) {
        res = true;
        // console.log(newMsgInChat + ' in if stmt');
    }
    
    if (res) {
        document.title = "New Message";
    } else {
        setTimeout(checkMsg, 2000);
    }
}

function tabMsg() {

    checkMsg();

    $(window).focus(function() {
        document.title = name;
        clearTimeout(checkMsg);
     
        document.title = "Username: " + name;
        return;
    });
}

$(window).blur(function() {
    setTimeout(tabMsg, 2000);
});

// document.title = 'blah';

// CLEAR CHAT 
$(function() {
    $('#clear').click(function() {
        $.get('clear.php', function(data) {
            // alert("Info: " + data);
            location.reload();
        });

        return false;
    });
});
