<?php
session_start();
// unset($_SESSION["cart"]);
// var_dump($_SESSION['cart']);

require_once ('./initdb.php');
require_once ('./functions.php');

$status = "";
if (!isset($_SESSION["cart"])) $_SESSION["cart"]=[];

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>The Hub | Pub & Club</title>


	<?php include "pocetni-linkovi.php"; ?>


</head>

<body>


	<?php include "nav.php" ?>


	<section class="home-slider owl-carousel" style="height:450px;">

		<div class="slider-item" style="background-image: url(images/meni.jpg);height:500px;" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row slider-text justify-content-center align-items-center">

					<div class="col-md-7 col-sm-12 text-center ftco-animate" style="margin-top:-200px;">
						<h1 class="mb-3 mt-5 bread">Meni</h1>
						<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Početna Stranica</a></span> <span>Meni</span></p>
					</div>

				</div>
			</div>
		</div>
	</section>

	<iframe name="cart_deflect" style="display:none;"></iframe>

	<section class="ftco-section">
		<div class="container" >
			<div class="row" >

			<!-- added to cart notification div -->
			<div class="notify"><span id="notifyType" class=""></span></div>

				<?php
				//redsoled stampanja za div-kartice(ima ih 9) : koje tipove jela svaka od kartica sadrzi 
				$print_divs_jela = [
					"div1" => ["Hladna predjela", "Topla predjela"],
					"div2" => "Jela po porudzbini",
					"div3" => ["Risotto", "Pizza", "Ribe i morski plodovi"],
					"div4" => ["Burrito", "Pasta"],
					"div5" => "Obrok salate",
					"div6" => "Burgeri",
					"div7" => "Dodaci",
					"div8" => ["Healthy food", "Slana palačinka"],
					"div9" => "Homemade sweets",
				];

				$daska = "<span style=\"font-size: 15px;color: #524f4f;\">daska</span>";
				$la_molisana = "<span style=\"font-size: 15px;color: #524f4f;\">la Molisana</span>";

				foreach ($print_divs_jela as $tip_jela) {
					echo "<div class=\"col-md-6 mb-5 pb-3\">";
					if (gettype($tip_jela) == "array") {
						foreach ($tip_jela as $sub_tip_jela) {
							echo "<h3 class=\"mb-5 heading-pricing ftco-animate\">";
							echo $sub_tip_jela;
							if ($sub_tip_jela == "Hladna predjela") echo " - $daska";
							if ($sub_tip_jela == "Pasta") echo " - $la_molisana";
							echo "</h3>";
							foreach ($menu as $item) {
								if ($item['product_type'] == 'jelo') printItem($item, $sub_tip_jela);
							}
						}
					} else {
						echo "<h3 class=\"mb-5 heading-pricing ftco-animate\">$tip_jela</h3>";
						foreach ($menu as $item) {
							if ($item['product_type'] == 'jelo') printItem($item, $tip_jela);
						}
					}
					echo "</div>";
				}
				?>
			</div>
		</div>
	</section>

	


	<?php include "footer.php"; ?>



	<?php include "skripte.php"; ?>

	<script>
        const order = (_id) => {
            data = {
                id: _id
            };
            data = JSON.stringify(data);
            fetch('./order.php',{
                method: "POST",
                body: data,
            }).then((response) => {
                response.json().then((data)=> {
                    console.log(data);
					if (data.cart_count != 0) {
						let cart_count = document.getElementById('cart_count');
						cart_count.innerHTML = data.cart_count;
						let cart_count_span = document.getElementById('cart_count_span');
						cart_count_span.style.visibility = 'visible';
						// let notification = document.getElementsByClassName('notify');
						// notification.classList.toggle("active");
						// let notificationType = document.getElementById('notifyType');
						// notificationType.classList.toggle("success");
						// setTimeout(function () {
						// 	notification.classList.remove("active");
						// 	notificationType.classList.remove("success");
						// }, 1000);
					}
                });
            })
        }
    </script>
</body>

</html>