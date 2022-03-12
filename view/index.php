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
					<span class="login100-form-title p-b-26">
						<img src="images/logo.png">
					</span>
					<div class="alert alert-danger" id="login-msg-return" style="display: none;">

					</div>

					<div class="wrap-input100 validate-input" data-validate="Informe um CPF válido">
						<input class="input100" oninput="applyCPFMask(this);" type="text" name="username">
						<span class="focus-input100" data-placeholder="CPF"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Informe uma data válida">
						<input class="input100" oninput="applyDataNascMask(this);" type="text" name="password">
						<span class="focus-input100" data-placeholder="Data de Nascimento"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button id="btn-login" class="login100-form-btn">
								Entrar
							</button>
						</div>
					</div>

					<div class="text-center p-t-15">
						<span class="txt1">
							Não possui uma conta?
						</span>

						<a class="txt2" href="create_account.html">
							<b><u>Cadastre-se</u></b>
						</a>
					</div>
				</form>
				<div class="text-center p-t-10">
					<span class="txt1">
						Versão: 1.0.4 - 
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