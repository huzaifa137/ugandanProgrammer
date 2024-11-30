@extends('layouts.master')

@section('css')
    <!-- Morris Charts css -->
    <link href="{{ URL::asset('assets/plugins/morris/morris.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
@endsection
@section('content')
    <!--Row-->
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <h4 class="page-title" style="text-align: center;">HEAD OF PROJECT/UNITS/DIVISIONS</h4>
            <div class="table-responsive">

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h3 class="heading">
                            <?php
                            
                            use App\Http\Controllers\Helper;
                            use App\Http\Controllers\MasterApproval;
                            use App\Http\Controllers\Controller;
                            $controller = new Controller();
                            
                            use App\Http\Controllers\TravelAuthorisationFormController;
                            $links = TravelAuthorisationFormController::links();
                            
                            $url = url()->current();
                            $url_parts = explode('/', $url);
                            $method = ucwords(str_replace(' ', ' ', lcfirst(str_replace('-', ' ', strtolower(@$url_parts[4])))));
                            
                            ?>
                        </h3>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">

                                @if (Session::get('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif


                                @if (Session::get('fail'))
                                    <div class="alert alert-danger">
                                        {{ Session::get('fail') }}
                                    </div>
                                @endif


                                <link rel="stylesheet" href="/assets/lib/multi-select/css/multi-select.css" />

                                <script src="/assets/lib/multi-select/js/jquery.multi-select.js"></script>
                                <script src="/assets/lib/multi-select/js/jquery.quicksearch.js"></script>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#searchable').multiSelect();
                                        $('#select_all').click(function() {
                                            $('#searchable').multiSelect('select_all');
                                        });
                                        $('#deselect_all').click(function() {
                                            $('#searchable').multiSelect('deselect_all');
                                        });
                                    });
                                </script>

                                <input type="hidden" value="{{ $role }}" id="role" />
                                @if (!$isHead)
                                    <div class="col-sm-12 col-md-12">
                                        <p><span class="label label-default">Pending Users</span></p>
                                        <select id="searchable" multiple="multiple">
                                            @foreach ($users as $user)
                                                @if (in_array($user->id, $ex))
                                                    <option selected value="{{ $user->id }}">
                                                        {{ Helper::full_name($user->id) }}</option>
                                                @else
                                                    <option value="{{ $user->id }}">{{ Helper::full_name($user->id) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-6 col-md-6"><br />
                                        <div class="btn btn-xs btn-warning pull-left" id="select_all">Select All</div>
                                        <div class="btn btn-xs btn-warning pull-right" id="deselect_all">Deselect All</div>
                                    </div>
                                    <div class="col-sm-6 col-md-6"><br />
                                        <div class="btn btn-primary pull-right" id="saveChanges"><i
                                                class="fa fa-fw fa-save"></i> Save Changes</div>
                                    </div>
                                @else
                                    <table id="table" border="1">
                                        <tr>
                                            <th style="width:30px;">No.</th>
                                            <th>Code</th>
                                            <th>Project/Unit/Division</th>
                                            <th>Head</th>
                                        </tr>

                                        <?php
                                        $year = DB::table('procurements')->where('is_item_planned', 1)->where('year_status', 'Enabled')->first();
                                        
                                        $active = DB::table('procurements')->distinct('requisition_division')->select('requisition_division')->where('is_item_planned', 1)->where('year_status', 'Enabled')->get();
                                        
                                        echo 'Active Procurement Plan: <b>' . Controller::rgf('master_datas', @$year->year, 'md_id', 'md_name') . '</b>';
                                        $active_list = [];
                                        foreach ($active as $item) {
                                            $active_list[] = $item->requisition_division;
                                        }
                                        
                                        $select = DB::table('master_datas')->select('master_datas.*')->join('master_codes', 'id', '=', 'md_master_code_id')->where('mc_name', 'Requisition Unit')->orderBy('md_name', 'ASC')->get();
                                        
                                        echo '<tr>';
                                        foreach ($select as $index => $row) {
                                            if (in_array($row->md_id, $active_list)) {
                                                echo '<tr>';
                                            } else {
                                                echo '<tr style="color:#999191;">';
                                            }
                                        
                                            echo '<td>' . ($index + 1) . '.</td>';
                                            echo '<td data-id="' . $row->md_id . '" title="' . $row->md_id . '">' . $row->md_code . ' </td>';
                                            echo '<td data-id="' . $row->md_id . '">' . $row->md_name . ' </td>';
                                        
                                            $head = '';
                                            $head = Controller::rgf2('users_and_roles', ['uar_head' => $row->md_id, 'uar_role_id' => $role], 'uar_user_id');
                                        
                                            echo '<td class="addHeadShow" data-head="' . $head . '" data-division-name="' . $row->md_name . '" data-division="' . $row->md_id . '">';
                                        
                                            if ($head) {
                                                echo '<b>' . Helper::full_name($head) . '</b> (' . Controller::rgf('admins', $head, 'id', 'email') . ')';
                                            } else {
                                                echo '<span style="color:red; font-weight:bold;">[Click to Add Head]</span>';
                                            }
                                        
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                        
                                        echo '<div class="modal fade border" id="addHead" aria-hidden="true" style="display: none;"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header">
                                                                                                                                                                                                                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 class="modal-title text-primary">Add Head or Project/Unit/Division</h3></div><div class="modal-body">';
                                        
                                        echo '<br/>';
                                        echo '<label style="font-weight:bold;">Selected Project/Unit/Division</label>';
                                        echo '<h3 id="modalDivision"></h3>';
                                        echo '<input type="hidden" value="" id="modalDivisionID"/>';
                                        echo '<br/>';
                                        echo '<label style="font-weight:bold;">Select Head\'s Name</label>';
                                        echo '<select class="form-control" id="modalName">';
                                        echo '<option value="">-- Select --</option>';
                                        foreach ($users as $user) {
                                            echo '<option value="' . $user->id . '">' . Helper::full_name($user->id) . '</option>';
                                        }
                                        echo '</select>';
                                        
                                        echo '<br/>';
                                        
                                        echo '<button id="saveHead" class="btn btn-primary btn-primary"><i class="fa fa-fw fa-save"></i> Save Head </button>';
                                        
                                        echo '</div>
                                                                                                                                                                                                                                                                            <div class="modal-footer">
                                                                                                                                                                                                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                            </div>';
                                        
                                        ?>

                                    </table>
                                @endif

                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                <script type="text/javascript">
                                    $(document).ready(function() {

                                        $('.addHeadShow').click(function() {
                                            var division = $(this).attr('data-division-name');
                                            var id = $(this).attr('data-division');
                                            var head = $(this).attr('data-head');
                                            $('#modalDivision').html(division);
                                            $('#modalDivisionID').val(id);
                                            $('#modalName').val(head);
                                            $('#addHead').modal('show');
                                        });

                                        $(document).on('click', '#saveHead', function() {
                                            division = $('#modalDivisionID').val();
                                            role = $('#role').val();
                                            user_id = $('#modalName').val();

                                            if (1) {
                                                $(this).append(' <img class="loader" src="/assets/img/loading.gif" alt="..."/>').attr(
                                                    'disabled', true);

                                                form_data = new FormData();

                                                form_data.append('role', role);
                                                form_data.append('division', division);
                                                form_data.append('user_id', user_id);

                                                $.ajax({
                                                    type: "post",
                                                    processData: false,
                                                    contentType: false,
                                                    cache: false,
                                                    data: form_data,
                                                    url: '/save-user-roles-and-head',
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    success: function(data) {
                                                        location.reload();
                                                    },
                                                    error: function(data) {
                                                        $('body').html(data.responseText);
                                                    }
                                                });

                                            } else {
                                                return false;
                                            }
                                        });

                                        var ids = new Array();
                                        $('#saveChanges').click(function() {
                                            $("#searchable option:selected").each(function() {
                                                ids.push($(this).val());
                                            });

                                            var role = $('#role').val();

                                            var idsu = ids.join(',');

                                            if (1) {
                                                form_data = new FormData();
                                                form_data.append('role', role);
                                                form_data.append('ids', idsu);

                                                $.ajax({
                                                    type: "post",
                                                    processData: false,
                                                    contentType: false,
                                                    cache: false,
                                                    data: form_data,
                                                    url: '/save-user-roles',
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    success: function(data) {
                                                        location.reload();
                                                    },
                                                    error: function(data) {
                                                        $('body').html(data.responseText);
                                                    }
                                                });

                                            } else {
                                                return false;
                                            }

                                        });
                                    });
                                </script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End row-->



    <!--Row-->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">

        </div>
    </div>

    <!--End row-->
    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.checkAll').click(function() {
                var firstCheckBox = false;
                $('.all').each(function(index) {
                    if (index == 0) {
                        firstCheckBox = ($(this).is(':checked')) ? true : false;
                    }

                    if (!firstCheckBox)
                        $(this).attr('checked', true);
                    else
                        $(this).attr('checked', false);

                });
            });
            $('.checkAll2').click(function() {
                var firstCheckBox = false;
                $('.all2').each(function(index) {
                    if (index == 0) {
                        firstCheckBox = ($(this).is(':checked')) ? true : false;
                    }

                    if (!firstCheckBox)
                        $(this).attr('checked', true);
                    else
                        $(this).attr('checked', false);

                });
            });
        });
    </script>


    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/chart.extension.js') }}"></script>
    <!-- ECharts js-->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <script src="{{ URL::asset('assets/js/index2.js') }}"></script>
@endsection
