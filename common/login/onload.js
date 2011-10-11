$(function(){

	if(navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
		$(window).load(function(){
			$('input:-webkit-autofill').each(function(){
				var text = $(this).val();
				var name = $(this).attr('name');
				$(this).after(this.outerHTML).remove();
				$('input[name=' + name + ']').val(text);
			});
		});
	}

	$("form input[type=text]").focus(function(){
		if($(this).val()==$(this).attr('name')){
			$(this).val('').css('color', '#414141');
		}
	});

	$("form input[type=text]").blur(function(){
		if($(this).val()==''){
			$(this).val($(this).attr('name')).css('color', '#ccc');
		}
	});

	$("#fakepassword").focus(function(){
		$(this).hide();
		$('#password').show().focus().css('color', '#414141');
	});

	$("#password").blur(function(){
		if($(this).val()==''){
			$(this).hide();
			$("#fakepassword").show();
		}
	});

	$("#fakepassword2").focus(function(){
		$(this).hide();
		$('#password2').show().focus().css('color', '#414141');
	});

	$("#password2").blur(function(){
		if($(this).val()==''){
			$(this).hide();
			$("#fakepassword2").show();
		}
	});

	$('#login_form').submit(function(){
		$.post("check_login", { username: $('#username').val(), password: $('#password').val() },
			function(data){
				if(data=='bad'){
					$('#message_container').fadeOut().removeClass().addClass('baduser').fadeIn();
					$('#password').val('');
				} else {
					if(data.substring(0, 8)=='redirect'){
						window.location = data.replace('redirect: ', '');
					} else {
						$('#message_container').fadeOut();
						$('#login_form').fadeOut(500, function(){
							$('body').append('<div id="classes" style="display:none;">'+data+'</div>');
							$('#classes').fadeIn(300);
						});
					}
				}
			}
		);
		return false;
	});

	$('#signup_form').submit(function(){
		if($('#first').val()=='First Name'||$('#last').val()=='Last Name'||$('#username').val()=='Desired Username'||$('#password').val()==''||$('#password2').val()==''){
			$('#message_container').fadeOut().removeClass().addClass('fillin').fadeIn();
		} else if($('#password').val()!=$('#password2').val()){
			$('#message_container').fadeOut().removeClass().addClass('nomatch').fadeIn();
		} else if($('#password').val().length<6){
			$('#message_container').fadeOut().removeClass().addClass('shortpass').fadeIn();
		} else if($('#username').val().length<4){
			$('#message_container').fadeOut().removeClass().addClass('shortuser').fadeIn();
		} else if($('#username').val()==$('#password').val()){
			$('#message_container').fadeOut().removeClass().addClass('same').fadeIn();
		} else {
			$.post("available", { username: $('#username').val() },
				function(data){
					if(data=='bad'){
						$('#message_container').fadeOut().removeClass().addClass('taken').fadeIn();
					} else {
						var classes = 'c';
						$('.class.sel').each(function(){
							classes += $('input', this).val();
						});
						$.post("check_sign_up", { first_name: $('#first').val(), last_name: $('#last').val(), user_name: $('#username').val(), password: $('#password').val(), classes: classes },
							function(data){
								window.location = data.replace('redirect: ', '');
							}
						);
					}
				}
			);
		}
		return false;
	});

	$('#close').click(function(){
		$('#message_container').fadeOut().removeClass();
	});

	$('#signup_form .class').toggle(function(){
		$(this).addClass('sel');
	}, function(){
		$(this).removeClass('sel');
	});

});
