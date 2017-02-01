<?php
	$time = time();
?>
<script>
	function ajaxFunction(url,somefunction)
		{
			var xmlHttp;
			try
			{
				xmlHttp=new XMLHttpRequest();
			}
			catch (e)
			{
				try
		    	{
					xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch (e)
				{
					try
					{
						xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					catch (e)
					{
						alert("Your browser does not support AJAX!");
					}
				}
			}
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					eval(somefunction+"(xmlHttp.responseText);");
				}
			}
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}

		function send_message(){
			var	t = new Date();
			var hour = t.getHours(); // Jumlah jam (0-23)
			var minute = t.getMinutes(); // Jumlah menit (0-59)
			var second = t.getSeconds(); // Jumlah detik (0-59)
			var daynumber = t.getDay();
			var monthnumber = t.getMonth() + 1; // Jumlah bulan (0-11)
			var monthday = t.getDate(); // Hari dari bulan (0-31)
			var year = t.getFullYear();
			//jam
			if(monthnumber < 10) monthnumber ='0'+monthnumber;
			if(hour < 10) hour ='0'+hour;
			if(minute < 10) minute ='0'+minute;
			if(second < 10) second ='0'+second;
			
			//time = monthday+'-'+monthnumber+'-'+year+', '+hour+':'+minute+':'+second;
			time = hour+':'+minute+':'+second;
			message = document.getElementById('message').value;
			var username = getCookie('username');

			datas = '[' + username + '] [' + time + '] : ' + document.getElementById('message').value + '<br>';
			ajaxFunction("api.php?command=send&text=" + message,"chatbox_display");
			document.getElementById('chatbox').innerHTML += datas;
			document.getElementById('message').value = '';
		}

		function getCookie(name) {
			var nameEQ = name + "=";
			//alert(document.cookie);
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
		if (c.indexOf(nameEQ) != -1) return c.substring(nameEQ.length,c.length);
		}
			return null;
		} 

		function checkCookie() {
			var x = getCookie('username');
			if(x === null)
			{
				document.getElementById('livechat-datainput').style.display = 'block';
				document.getElementById("message").disabled = true;
			}
			else
			{
				document.getElementById('livechat-datainput').style.display = 'none';
				document.getElementById("message").disabled = false;
			}
		}

		function setCookie(username){
			document.cookie = 'username=' + username + '; expires=Thu, 18 Dec 2113 12:00:00 UTC';
			checkCookie();
			ajaxFunction("api.php?command=send&text=" + username +" Telah Bergabung ke dalam Chat. ","chatbox_display");
		}

		function clearCookie(){
			confirm = confirm('Apakah anda ingin keluar dari chat ?');
			if(confirm)
			{
				document.cookie = 'username=; expires=Thu, 1 Jan 1970 12:00:00 UTC';
				document.getElementById('livechat-datainput').style.display = 'block';
				document.getElementById("message").disabled = true;
			}
		}

		function chat_history(){
			var	t = new Date();
			ajaxFunction("api.php?command=receive","chatbox_display");
			setTimeout("chat_history()", 1000);
		}

		function chatbox_display(datas){
			if(datas != '')
			{
				document.getElementById('chatbox').innerHTML += datas;
			}
		}
		function handle(e){
		        if(e.keyCode === 13){
					var x = getCookie('username');
					if(x !== null)
					{
		        		send_message();
		        	}
		            e.preventDefault();
		        }
		    }
		function handle_username(e){
		        if(e.keyCode === 13){
					username = document.getElementById('username').value;
		        	setCookie(username);
		            e.preventDefault();
		        }
		    }

</script>
<style>
body{
	font-size:12px;
	font-family: arial;
}
</style>
<body onload="chat_history(); checkCookie();">
<style>
	.livechat-wrap{
		width: 750px;
		position: fixed;
		top: 50px;
		left: 50px;
	}
	.livechat-header{
		font-size:18px;
		background-color:343434;
		font-weight: bold;
		color:#fff;
		padding:8px 15px;
		position: relative;
		height: 23px;
	}
	.livechat-command{
		font-size: 20px;
		float:right;
	}
	.livechat{
		border:solid 1px #aeaeae;
		position: relative;
	}
	.livechat-text{
		width: 100%;
		border: none;
		padding: 5px;
	}
	.chatbox
	{
		border-bottom:solid 1px #aeaeae;
		width: 735px;
		height: 420px;
		padding:7px;
		overflow: auto;
		overflow-x: hidden;
		display: block;
	}
	.livechat-datainput{
		background:url('images/tembus.png');
		height: 503px;
		width: 750px;
		position: absolute;
		z-index: 1;
	}
	.livechat-datainput-box{
		width: 100%;
		text-align: center;
	}
	.livechat-datainput-field{
		width: 200px;
		margin: 150px auto;
		padding:50px;
		border: solid 1px #cecece;
		background-color: #cecece;
	}
</style>
<div class="livechat-wrap">
	<div class="livechat-datainput" id="livechat-datainput">
		<div class="livechat-datainput-box">
			<div class="livechat-datainput-field">
				Masukkan Username : <input type="text" name="username" id="username" onkeypress="handle_username(event)">
			</div>
		</div>
	</div>
	<div class="livechat-header" onclick="clearCookie()">
		Livechat Support <div class="livechat-command">_</div>
	</div>
	<div class="livechat" id="livechat_box">
		<div class="chatbox" id="chatbox">

		</div>
		<input type="text" name="message" id="message" onkeypress="handle(event)" class="livechat-text">
		<input type="hidden" name="hidden" id="hidden">
	</div>
</div>
</body>