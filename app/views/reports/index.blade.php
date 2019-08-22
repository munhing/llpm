@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="pagege-title">
		Reports <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Reports
			</li>			
		</ul>
	</div>	

<div class="row">
    <div class="col-md-3">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <span class="caption-subject bold uppercase">Vessel</span>
                    <span class="caption-helper">reports</span>
                </div>    
            </div>
            <div class="portlet-body">
                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-condensed table-light">
                        <tbody>
                            <tr>
                                <td>
                                    <a href="{{route('reports.vessel.total.conf')}}" class="primary-link">Total Vessel</a>
                                </td>

                            </tr>                        
                            <tr>
                                <td>
                                    <a href="{{route('reports.vessel.top.conf')}}" class="primary-link">Top Vessel</a>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <a href="{{route('reports.vessel.top.agent.conf')}}" class="primary-link">Top Vessel Agent</a>
                                </td>

                            </tr>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-blue-steel">
                    <span class="caption-subject bold uppercase">Container</span>
                    <span class="caption-helper">reports</span>
                </div>    
            </div>
            <div class="portlet-body">
                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-condensed table-light">
                        <tbody>
                            <tr><td>
                                <a href="{{route('reports.container.loading.discharging.conf')}}" class="primary-link">Loading & Discharge By Vessel</a>
                            </td></tr>                        
                            <tr><td>
                                <a href="{{route('reports.container.movement.conf')}}" class="primary-link">Container Movement</a>
                            </td></tr>                            
                            <tr><td>
                                <a href="{{route('reports.container.teus.conf')}}" class="primary-link">Total TEUs</a>
                            </td></tr>
                            <tr><td>
                                <a href="{{route('reports.container.total.rpt')}}" class="primary-link" target="_blank">Total Containers in CY1 & CY3</a>
                            </td></tr>
                            <tr><td>
                                <a href="{{route('reports.container.transfer.to.CY3.conf')}}" class="primary-link">Total Containers Transfer from CY1 to CY3</a>
                            </td></tr>
                            <tr><td>
                                <a href="{{route('reports.container.transfer.to.CY1.conf')}}" class="primary-link">Total Containers Transfer from CY3 to CY1</a>
                            </td></tr>                            
                        </tbody>
                    </table>
                </div>       
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-thunderbird">
                    <span class="caption-subject bold uppercase">Cargo</span>
                    <span class="caption-helper">reports</span>
                </div>    
            </div>
            <div class="portlet-body">
                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-condensed table-light">
                        <tbody>
                            <tr>
                                <td>
                                    <a href="{{route('reports.cargo.mt.conf')}}" class="primary-link">Total Cargo MT</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{route('reports.cargo.containerized.mt.conf')}}" class="primary-link">Total Containerized Cargo MT</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{route('reports.cargo.loose.mt.conf')}}" class="primary-link">Total Loose Cargo MT</a>
                                </td>
                            </tr>                                                        
                            <tr>
                                <td>
                                    <a href="{{route('reports.cargo.top.import.conf')}}" class="primary-link">Top Import Cargo</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{route('reports.cargo.top.export.conf')}}" class="primary-link">Top Export Cargo</a>
                                </td>
                            </tr>    
                            <tr>
                                <td>
                                    <a href="{{route('reports.cargo.list.import.conf')}}" class="primary-link">Import Cargo List by Consignee</a>
                                </td>
                            </tr>    
                            <tr>
                                <td>
                                    <a href="{{route('reports.cargo.list.export.conf')}}" class="primary-link">Export Cargo List by Consignor</a>
                                </td>
                            </tr>   
                            <tr>
                                <td>
                                    <a href="{{route('reports.cargo.origin.conf')}}" class="primary-link">Top Origin</a>
                                </td>
                            </tr>   
                            <tr>
                                <td>
                                    <a href="{{route('reports.cargo.destination.conf')}}" class="primary-link">Top Destination</a>
                                </td>
                            </tr>                                                                                                                                 
                        </tbody>
                    </table>
                </div>         
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-yellow-gold">
                    <span class="caption-subject bold uppercase">Miscellaneous</span>
                    <span class="caption-helper">reports</span>
                </div>    
            </div>
            <div class="portlet-body">
                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-condensed table-light">
                        <tbody>
                            <tr>
                                <td>
                                    <a href="{{route('reports.misc.consignee.top.conf')}}" class="primary-link">Top Consignee</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{route('reports.misc.consignor.top.conf')}}" class="primary-link">Top Consignor</a>
                                </td>
                            </tr>                            
                        </tbody>
                    </table>
                </div>         
            </div>
        </div>
    </div>    
</div>




   
@stop

@section('page_level_plugins')


@stop

@section('scripts')


@stop