@php
$logo = App\Models\GeneralSetting::where("name","logo")->first();
$generalSettings =  App\Models\GeneralSetting::whereIn('name', [
        'about_us', 'how_to_sell_us', 'phone_number_1', 'phone_number_2', 'phone_number_3',
        'email_1', 'email_2', 'email_3', 'facebook', 'telegram', 'discord' , 'viber' , 'skype','address'
    ])->pluck('value', 'name');

@endphp
<footer class="site-footer footer-dark style-1"  style="background-color:black !important;">
		
		
		<!-- Footer Bottom -->
		<div class="footer-bottom">
			<div class="container">
				<div class="row fb-inner wow ">
					
					<div class="col-lg-12 col-md-12 text-start"> 
						<center>
						<p class="copyright-text" style="color:white !important">© {{env('APP_NAME')}}  - All rights reserved. </p>
						</center>
					</div>
					
				</div>
			</div>
		</div>
		<!-- Footer Bottom End -->
		
	</footer>