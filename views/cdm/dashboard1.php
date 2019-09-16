<!-- page content -->
<div class="right_col" role="main">
<div class="row top_tiles">
	<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
		<div class="tile-stats" style="background-color: #fbb13c;">
			<div class="col-lg-12 stat-total">
				<div class="col-lg-3 col-md-3 stat-icon"><i class="fa fa-ticket" aria-hidden="true" style="color: #fff"></i></div>
				<div class="col-lg-9 col-md-9 total-digit">
				<h4>Total Opportunities</h4>
				<div class="count total-count">$179,057</div>
				</div>
			</div>
			<div class="col-lg-6 pull-left sub-count">
				<p>YTD (Jan 1 - Dec 31)</p>
				<div class="count sub-count">$78,590</div>
			</div>
			<div class="col-lg-6 pull-right sub-count">
				<p>Year 2020</p>
				<div class="count sub-count">$100,467</div>
			</div>
		</div>	
	</div>
	<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
		<div class="tile-stats" style="background-color: #337ab7">
			<div class="col-lg-12 stat-total">
				<div class="col-lg-3 col-md-3 stat-icon"><i class="fa fa-suitcase" aria-hidden="true" style="color: #fff"></i></div>
				<div class="col-lg-9 col-md-9 total-digit">
				<h4>Total Signed</h4>
				<div class="count total-count">$102,548</div>
				</div>
			</div>
			<div class="col-lg-6 pull-left sub-count">
				<p>YTD (Jan 1 - Dec 31)</p>
				<div class="count sub-count">$64,881</div>
			</div>
			<div class="col-lg-6 pull-right sub-count">
				<p>Year 2020</p>
				<div class="count sub-count">$37,667</div>
			</div>
		</div>	
	</div>
	<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
		<div class="tile-stats" style="background-color:#24a556;">
			<div class="col-lg-12 stat-total">
				<div class="col-lg-3 col-md-3 stat-icon"><i class="fa fa-money" aria-hidden="true" style="color: #fff"></i></div>
				<div class="col-lg-9 col-md-9 total-digit">
				<h4>Total Signed & Policy Issued</h4>
				<div class="count total-count">$83,414</div>
				</div>
			</div>
<!--
			<div class="col-lg-6 pull-left sub-count">
				<p>YTD (Jan 1 - Dec 31)</p>
				<div class="count sub-count">$53,333</div>
			</div>
			<div class="col-lg-6 pull-right sub-count">
				<p>Year 2020</p>
				<div class="count sub-count">$30,081</div>
			</div>
-->
		</div>	
	</div>
	   <div class="col-lg-6 col-md-4 col-sm-3 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Gauge</h2>

			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
<!--			<div id="echart_gauge" style="width: 100%; min-height:370px;"></div>-->
<!--			  <canvas id="canvasDoughnut"></canvas>-->
			  <canvas id="chart_gauge_01"></canvas>
		  </div>
		</div>
	  </div>

</div>
	
	
	
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">


<!--
                      <div class="sidebar-widget">
                        <h4>Profile Completion</h4>
                        <canvas width="150" height="80" id="chart_gauge_01" class="" style="width: 160px; height: 100px;"></canvas>
                        <div class="goal-wrapper">
                          <span id="gauge-text" class="gauge-value gauge-chart pull-left">0</span>
                          <span class="gauge-value pull-left">%</span>
                          <span id="goal-text" class="goal-value pull-right">100%</span>
                        </div>
                      </div>
-->
		
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Weekly Sales</h2>
<!--
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
-->
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="height: 500px;">
<!--                    <div id="mainb" style="width: 100%; min-height: 350px;"></div>-->
					  <canvas id="mybarChart"></canvas>
                  </div>
                </div>

		
	</div>
	<div class="col-lg-4 col-md-4">
		<div class="panel" style="background-color:white;">
			<div class="x_title">
				<h4 class="pull-left">Client Tasks</h4>
				<ul class="panel_toolbox pull-right">
					<li><i class="fa fa-square" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Others" id="taskOthers"></i><span class="task-count">0</span></li>
					
					<li><i class="fa fa-square" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Email" id="taskEmail"></i><span class="task-count">3</span></li>
					
					<li><i class="fa fa-square" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Call/Meeting" id="taskCallmtg"></i><span class="task-count">1</span></li>
					
					<li><i class="fa fa-square" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Meeting"  id="taskMtg"></i><span class="task-count">6</span></li>
					
					<li><i class="fa fa-square" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Call" id="taskCall"></i><span class="task-count">2</span></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x-content">
				<article class="media event task-call">
					<div class="media-body">
						<a class="clt-name">John DOE</a>
						<p class="task-details">Call at 4 PM today</p>
					</div>
				</article>
				<article class="media event task-mtg">
					<div class="media-body">
						<a class="clt-name">Rey CASTANARES</a>
						<p class="task-details">Review quote</p>
					</div>
				</article>
				<article class="media event task-email">
					<div class="media-body">
						<a class="clt-name">Vivencia VELASCO</a>
						<p class="task-details">Receive payment</p>
					</div>
				</article>
				<article class="media event task-others">
					<div class="media-body">
						<a class="clt-name">Kevin DEGAMO</a>
						<p class="task-details">Purchase lunch</p>
					</div>
				</article>
			</div>
		</div>
	</div>
</div>
	
	
	
	
	
<!--	end-->
	
	
</div>


	
	
	
	
	
<!-- /page content> -->
<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
