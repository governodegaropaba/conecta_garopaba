<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<title>Login - Conecta Garopaba</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
</head>
<body>	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form">
					<input type="hidden" name="domain" value="">
					<input type="hidden" name="dst" value="http://www.mikrotik.com">
					<input type="hidden" name="url" value="http://192.168.45.1/login">
					<div style="float: right; cursor: pointer;"><a
						onclick="$('.page-language').css('display', 'none'); $('.page-ptbr').css('display', '');"><img
						  style="max-width: 100%;"
						  src="images/flag_brazil.png"></a>
					  <a onclick="$('.page-language').css('display', 'none'); $('.page-english').css('display', '');"><img
						  style="max-width: 100%;"
						  src="images/flag_usa.png">
					  </a> <a onclick="$('.page-language').css('display', 'none'); $('.page-spanish').css('display', '');"><img
						  style="max-width: 100%;"
						  src="images/flag_spain.png"></a>
					</div>
					<span class="login100-form-title p-b-26">
						<img src="images/logo.png">
					</span>
					<div class="alert alert-danger" id="login-msg-return" style="display: none;">

					</div>	
					<!-- CPF/TELEFONE -->				
					<div class="page-language page-ptbr wrap-input100 validate-input" data-validate="Informe um CPF válido">
						<input class="input100" oninput="applyCPFMask(this);" type="text" name="username">
						<span class="focus-input100" data-placeholder="CPF"></span>
					</div>
					<div class="page-language page-english wrap-input100 validate-input" style="display: none;" data-validate="Enter your phone number">
						<input class="input100" type="text" name="username_en">
						<span class="focus-input100" data-placeholder="Phone number"></span>
					</div>
					<div class="page-language page-spanish wrap-input100 validate-input" style="display: none;" data-validate="Ingrese su número telefónico">
						<input class="input100" type="text" name="username_es">
						<span class="focus-input100" data-placeholder="Número de teléfono"></span>
					</div>

					<!-- DATA NASC -->
					<div class="page-language page-ptbr wrap-input100 validate-input" data-validate="Informe uma data válida">
						<input class="input100" oninput="applyDataNascMask(this);" type="text" name="password">
						<span class="focus-input100" data-placeholder="Data de Nascimento"></span>
					</div>
					<div class="page-language page-english wrap-input100 validate-input" style="display: none;" data-validate="Enter a valid date">
						<input class="input100" oninput="applyDataNascMask(this);" type="text" name="password">
						<span class="focus-input100" data-placeholder="Birth date"></span>
					</div>
					<div class="page-language page-spanish wrap-input100 validate-input" style="display: none;" data-validate="Introduzca una fecha válida">
						<input class="input100" oninput="applyDataNascMask(this);" type="text" name="password">
						<span class="focus-input100" data-placeholder="Fecha de nacimiento"></span>
					</div>

					<!-- SUBMIT -->
					<div class="page-language page-ptbr container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button id="btn-login" class="login100-form-btn">
								Entrar
							</button>
						</div>
					</div>
					<div class="page-language page-english container-login100-form-btn" style="display: none;">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button id="btn-login" class="login100-form-btn">
								Login
							</button>
						</div>
					</div>
					<div class="page-language page-spanish container-login100-form-btn" style="display: none;">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button id="btn-login" class="login100-form-btn">
								Entrar
							</button>
						</div>
					</div>

					<!-- CRIAR CONTA -->
					<div class="page-language page-ptbr text-center p-t-15">
						<span class="txt1">
							Não possui uma conta?
						</span>

						<a class="txt2" href="create_account.html">
							<b><u>Cadastre-se</u></b>
						</a>
					</div>
					<div class="page-language page-english text-center p-t-15" style="display: none;">
						<span class="txt1">
							Don't have an account?
						</span>

						<a class="txt2" href="create_account.html">
							<b><u>Register</u></b>
						</a>
					</div>
					<div class="page-language page-spanish text-center p-t-15" style="display: none;">
						<span class="txt1">
							¿No tienes una cuenta?
						</span>

						<a class="txt2" href="create_account.html">
							<b><u>Registro</u></b>
						</a>
					</div>
				</form>
				<div class="text-center p-t-10">
					<span class="txt1">
						Versão: 1.0.5 -
					</span>

					<a class="txt2" href="mailto:dti@garopaba.sc.gov.br">
						dti@garopaba.sc.gov.br
					</a>
				</div>
			</div>
		</div>
	</div>

	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>
</body>

</html>