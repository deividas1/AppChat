<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/chat.js"></script>
    <script type="text/javascript">

      var name = "Guest";
      // ask user for name with popup prompt
      function getNickname() {
        // var name1 used for preventing set to null if prompt was canceled
        var name1 = prompt("Enter your chat name:", name);
        if (!name1 || name1 === ' ') {
          return false  ;
        } else {
          // strip tags
          name = name1.replace(/(<([^>]+)>)/ig,"");
          return true;
        }
      }

      getNickname();
      //
      document.title = 'Username: ' + name;
    	// display name on page
    	$("#name-area").html("You are: <span>" + name + "</span>");
    	// kick off chat
      var chat =  new Chat();

      $(function() {
      
         chat.getState(); 
         chat.send("Logged in", name);
         
         // watch textarea for key presses
             $("#sendie").keydown(function(event) {  
             
                 var key = event.which;  
           
                 //all keys including return.  
                 if (key >= 33) {
                   
                     var maxLength = $(this).attr("maxlength");  
                     var length = this.value.length;  
                     
                     // don't allow new content if length is maxed out
                     if (length >= maxLength) {  
                         event.preventDefault();  
                     }  
                  }  
    		 					  });
    		 // watch textarea for release of key press
    		 $('#sendie').keyup(function(e) {	
    		 					 
    			  if (e.keyCode == 13) { 
    			  
                    var text = $(this).val();
            				var maxLength = $(this).attr("maxlength");  
                    var length = text.length; 
                     
                    // send 
                    if (length <= maxLength + 1) { 
                     
    			        chat.send(text, name);	
    			        $(this).val("");
                    } else {
    					         $(this).val(text.substring(0, maxLength));
    				        }	
    			  }
        });

        $('#chat-area').on('click', 'p span', function(event) {
            var el = event.target;
            if (el.innerHTML == name) {
              if (getNickname()) {
                chat.send("Nick changed", name);
              }
            }
        });
           
        $('#chat-area').on('mouseenter', 'p span', function(event) {
          var el = event.target;
          if (el.innerHTML == name) {
            el.style.cursor = "pointer";
          }
        });

        $('#chat-area').on('mouseleave', 'p span', function(event) {
          var el = event.target;
          if (el.innerHTML == name && el.style.cursor == "pointer" ) {
            el.style.cursor = "default";
          }
        });

        $('#upload1').click(function() {
          $('#inputFile').click();
        });

        $('#inputFile').on('change', function(event) {

          event.stopPropagation(); // Stop stuff happening
          event.preventDefault(); // Totally stop stuff happening
        
          var formData = new FormData();
          var el = $('#inputFile');
          formData.append("inputFile", el[0].files[0]);

          // code samples
          // http://abandon.ie/notebook/simple-file-uploads-using-jquery-ajax
          // https://developer.mozilla.org/en-US/docs/Web/API/FormData/Using_FormData_Objects

          $.ajax({
              type: 'POST',
              url: 'files.php',
              data: formData,
              cache: false,
              dataType: 'json',
              async: true,
              processData: false, // Don't process the files
              contentType: false, // Set content type to false as jQuery will tell the server its a query string request
              success: function(data) {
                var msg = "";
                if (data['error'] == undefined) {
                  var file = data['files'][0].split('/')[1];
                  msg = 'File: <a href="files.php?function=get&file=';
                  msg += file +'">' + file + '</a>';
                } else {
                  msg = 'Error: ' + data['error'];
                }  
                chat.send(msg, name);
              },
              error: function(data) {
                chat.send('Error:' + data['error'], name);
              }
          });
        });

    	});
    </script>

</head>

<body onload="setInterval('chat.update()', 1000)">
    <div class="wrap">
      <div class="chat-wrap">
          <h2>Off Grid <span>Chat</span></h2>

          <div id="chat-wrap">
            <div id="chat-area"></div>
          </div>
          <form id="send-message-area">
              <p>your message: </p>
              <textarea id="sendie" maxlength ='255' autofocus></textarea>
          </form>
          <button id="upload1">Upload</button>
          <input id='inputFile' type='file' style="display:none">
          <button id="clear">Reset</button>
      </div>
    </div>
</body>
</html>
