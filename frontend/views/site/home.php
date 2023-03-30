<?php

use yii\helpers\Url;

$this->title = "Kabinet";
?>
<div class="container">
	<div class="row">
		<div class="col-lg-10 offset-lg-1">
			<div class="row">
				<div class="col-lg-6">
					<div class="alert alert-success">
						<p>Foydalanuvchilar: <a href="<?=Url::to(['/user'])?>"><?=$model_users?></a></p>
						<!-- <span class="badge text-bg-warning"><a href="?">56565</a></span> -->
					</div>
				</div>
				<div class="col-lg-6">
					<div class="alert alert-success">
						<p>Jami e'lonlar: <a href="<?=Url::to(['/posters'])?>"><?=$model_posters?></a></p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="alert alert-success">
						<p>Shikoyatlar: <a href="#">25</a></p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="alert alert-success">
						<p>Maqtovlar: <a href="#">25</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>