function admin_menu()
{
	var s_menu;

	s_menu="<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>" + "\n"
		+ "			<div class='container-fluid'>" + "\n"
		+ "				<a class='navbar-brand text-white' href='../admin/index.html'>관리자</a>" + "\n"
		+ "				<button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>" + "\n"
		+ "				<span class='navbar-toggler-icon'></span>" + "\n"
		+ "				</button>" + "\n"
		+ "				<div class='collapse navbar-collapse' id='navbarNav'>" + "\n"
		+ "					<ul class='navbar-nav  me-auto' style='font-size:15px'>" + "\n"
		+ "						<li class='nav-item'><a class='nav-link' href='member.php'>회원관리</a></li>" + "\n"
		+ "						<li class='nav-item'><a class='nav-link' href='product.php'>제품관리</a></li>" + "\n"
		+ "						<li class='nav-item'><a class='nav-link' href='jumun.php'>주문관리</a></li>" + "\n"
		+ "						<li class='nav-item'><a class='nav-link' href='opt.php'>옵션관리</a></li>" + "\n"
		+ "						<li class='nav-item'><a class='nav-link' href='faq.php'>FAQ</a></li>" + "\n"
		+ "					</ul>" + "\n"
		+ "					<a class='btn btn-sm btn-outline-secondary btn-dark' href='../index.html'>Goto SHOP</a>" + "\n"
		+ "				</div>" + "\n"
		+ "			</div>" + "\n"
		+ "		</nav>" + "\n"
		+ "		<br><br><br>" + "\n";

	return s_menu;
}



