
var instanse = false;
var state;
var mes;
var file;

function Chat() {
    this.update = updateChat;
    this.send = sendChat;
    this.getState = getStateOfChat;
}

//gets the state of the chat
function getStateOfChat() {
    if (!instanse) {
        instanse = true;
        $.ajax({
            type: "POST",
            url: "process.php",
            data: {
                'function': 'getState',
                'file': file
            },
            dataType: "json",

            success: function(data) {
                state = data.state;
                instanse = false;
            },
        });
    }
}

function digits1(i1) {
  return ("0" + i1).slice(-2);
}

//Updates the chat
function updateChat() {
    if (!instanse) {
        instanse = true;
        $.ajax({
            type: "POST",
            url: "process.php",
            data: {
                'function': 'update',
                'state': state,
                'file': file    
            },
            dataType: "json",
            success: function(data) {
                if (data.text) {
                    for (var i = 0; i < data.text.length; i++) {

                        // Time of the post
                        // sita reikes perkelti i app.js faila
                        var dt = new Date();
                        var timeNow = digits1(dt.getHours()) + ":" + digits1(dt.getMinutes()) 
                            + ":" + digits1(dt.getSeconds());

                        // Chat insert text
                        $('#chat-area').append($("<p>" + data.text[i] + "</p>"));

                        // Chat insert time
                        $('#chat-area span').last().after($("<time>" + timeNow +  "</time>"));

                        // Play sound if other user sends msg 
                        var nameInSpan = $('#chat-area span').last().text();
                        if (name != nameInSpan) {
                            snd.play();
                        };

                    }
                }
                document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
                instanse = false;
                state = data.state;
            },
        });
    } else {
        setTimeout(updateChat, 1500);
    }
}

//send the message
function sendChat(message, nickname) {
    updateChat();
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {
            'function': 'send',
            'message': message,
            'nickname': nickname,
            'file': file
        },
        dataType: "json",
        success: function(data) {
            updateChat();
        },
    });
}
