<?php 
	session_start();
?>

<header>
		<img class="logo" src="{{ asset('img/True logo.png') }}" alt="Logo">

		<nav>
			<ul>
				<li><a href="../main/index.php"> Trang chủ </a></li>
				<li><a href="../html/all-game.php"> Games </a></li>
				<li><a href="#"> Tin Tức </a></li>
				<li><a href="#"> Liên hệ </a></li>
				<?php
					if(isset($_SESSION["userName"]))
					{
						if($_SESSION["userType"]== "admin")
						{
							echo "<li><a href='../html/profile.php'> Trang cá nhân </a></li>";
							echo "<li><a href='../admin/admin-index.php'> Quản lý </a></li>";
							echo "<li><a href='../inc/logout.inc.php'> Đăng xuất </a></li>";
							echo "<li>".$_SESSION["userEmail"]." </li>";
						}
						else
						{
							echo "<li><a href='../html/profile.php'> Trang cá nhân </a></li>";
							echo "<li><a href='../inc/logout.inc.php'> Đăng xuất </a></li>";
							echo "<li>".$_SESSION["userEmail"]." </li>";

						}
					}
					else
					{
						echo "<li><a href='../html/log-acc.php'> Tài Khoản </a></li>";
					}
				?>
				
			</ul>
		</nav>
</header>