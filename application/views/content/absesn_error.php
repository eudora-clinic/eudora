<?php
# Penambahan select option job dan location
# load database oriskin (lihat di config/database.php)
$db_oriskin = $this->load->database('oriskin', true);	

$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m-d'));
$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date("Y-m-d", strtotime($datestart . " +1 day")));
?>

<div class="card shadow mb-4" style="margin-left:20px; margin-right:20px;">
    <div class="card-body">
        <h4 class="card-title mb-3">Absen Clinic</h4>
		
        <?php
        # display error
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        # unlimited time
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', '-1');
        // Setting memory limit sql server to 512M
        ini_set('sqlsrv.ClientBufferMaxKBSize', '524288');
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288');
        # dibuat langsung di view untuk memudahkan 
        # tidak dibuat di model
        $locationid = $this->session->userdata('locationid');
        $userid = $this->session->userdata('userid');
        
        $date = $datestart;
        $dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date("Y-m-d", strtotime($date . " 0 day")));
        // $employeeid = (isset($_GET['employeeid']) ? $this->input->get('employeeid') : '');
        $job_list = $db_oriskin->query("SELECT a.id AS EMPLOYEEID, a.name AS EMPLOYEENAME, 
        b.locationid AS LOCATIONID, c.id AS JOBID, c.name AS JOBNAME from msemployee a inner join msemployeedetail b ON a.id = b.employeeid
        inner join msjob c ON b.jobid = c.id WHERE b.jobid IN (6,12) AND b.locationid = '".$locationid."'")->result_array();
        
        $db_oriskin = $this->load->database('oriskin', true);
        # query
        $query = $db_oriskin->query("
            select 
            a.id as ID,
            a.employeeid as EMPLOYEEID,
            b.name AS EMPLOYEENAME,
            a.jobid AS JOBID,
            d.name AS JOB
            FROM msabsen a
            INNER JOIN msemployee b ON a.employeeid = b.id
            INNER JOIN msemployeedetail c ON b.id = c.employeeid
            INNER JOIN msjob d ON c.jobid = d.id
        ");
        $header = $query->result_array();
        ?>

        <!-- <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
            <div class="form-row mt-9">
                <div class="form-group col-md-3">
                    <div class="form-group bmd-form-group">
                        <label >Date Start</label>
                        <input type="date" id="datestart" name="datestart" class="form-control" required="true" aria-required="true" placeholder="" value="<?= $date ?>">
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="btn-sm btn-outline-primary" style="width: 150px; height:100%;" value="true">Cari</button>
        </form> -->

        <div class="tab-content">

            <!-- Large modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Tambah Data</button>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Input Data Absen (Employee)</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-cari-invoice" method="post" action="<?= base_url('save-employee-absen') ?>">
                                    <select id="employeeSelect" class="form-control">
                                        <option selected>Choose Employee...</option>
                                        <?php
                                        foreach ($job_list as $employee) {
                                            echo "<option value='" . $employee['EMPLOYEEID'] . "'>" . $employee['EMPLOYEENAME'] . "</option>";
                                        }
                                        ?>
                                    </select>

                                    <select id="jobSelect" class="form-control">
                                        <option selected>Choose Job</option>
                                        <?php
                                        foreach ($job_list as $job) {
                                            echo "<option value='" . $job['JOBID'] . "'>" . $job['JOBNAME'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                        <br>
                                    <div class="form-group">
                                    <label for="period">Period:</label>
                                    <input type="text" class="form-control" id="periodSelect" value="<?= date('Y-m'); ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                    <div class="checkbox">
                                    <label><input type='checkbox' name='_1' id='_1Select' value='1'>1</label>
                                    <label><input type='checkbox' name='_2' id='_2Select' value='1'>2</label>
                                    <label><input type='checkbox' name='_3' id='_3Select' value='1'>3</label>
                                    <label><input type='checkbox' name='_4' id='_4Select' value='1'>4</label>
                                    <label><input type='checkbox' name='_5' id='_5Select' value='1'>5</label>
                                    <label><input type='checkbox' name='_6' id='_6Select' value='1'>6</label>
                                    <label><input type='checkbox' name='_7' id='_7Select' value='1'>7</label>
                                    <label><input type='checkbox' name='_8' id='_8Select' value='1'>8</label>
                                    <label><input type='checkbox' name='_9' id='_9Select' value='1'>9</label>
                                    <label><input type='checkbox' name='_10' id='_10Select' value='1'>10</label>
                                    </div>
                                    <div class="checkbox">
                                    <label><input type='checkbox' name='_11' id='_11Select' value='1'>11</label>
                                    <label><input type='checkbox' name='_12' id='_12Select' value='1'>12</label>
                                    <label><input type='checkbox' name='_13' id='_13Select' value='1'>13</label>
                                    <label><input type='checkbox' name='_14' id='_14Select' value='1'>14</label>
                                    <label><input type='checkbox' name='_15' id='_15Select' value='1'>15</label>
                                    <label><input type='checkbox' name='_16' id='_16Select' value='1'>16</label>
                                    <label><input type='checkbox' name='_17' id='_17Select' value='1'>17</label>
                                    <label><input type='checkbox' name='_18' id='_18Select' value='1'>18</label>
                                    <label><input type='checkbox' name='_19' id='_19Select' value='1'>19</label>
                                    <label><input type='checkbox' name='_20' id='_20Select' value='1'>20</label>
                                    </div>
                                    <div class="checkbox">
                                    <label><input type='checkbox' name='_21' id='_21Select' value='1'>21</label>
                                    <label><input type='checkbox' name='_22' id='_22Select' value='1'>22</label>
                                    <label><input type='checkbox' name='_23' id='_23Select' value='1'>23</label>
                                    <label><input type='checkbox' name='_24' id='_24Select' value='1'>24</label>
                                    <label><input type='checkbox' name='_25' id='_25Select' value='1'>25</label>
                                    <label><input type='checkbox' name='_26' id='_26Select' value='1'>26</label>
                                    <label><input type='checkbox' name='_27' id='_27Select' value='1'>27</label>
                                    <label><input type='checkbox' name='_28' id='_28Select' value='1'>28</label>
                                    <label><input type='checkbox' name='_29' id='_29Select' value='1'>29</label>
                                    <label><input type='checkbox' name='_30' id='_30Select' value='1'>30</label>
                                    <label><input type='checkbox' name='_31' id='_31Select' value='1'>31</label>
                                    </div>
                                    </div>

                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            
            

          <!-- Pastikan Anda telah memasukkan jQuery library di halaman Anda -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function submitForm() {
        // Dapatkan nilai dari input select untuk employee, job, dan period
        var employeeid = $('#employeeSelect').val();
        var jobid = $('#jobSelect').val();
        var period = $('#periodSelect').val();
        
        var _1 = $('#_1Select').val();
        var _2 = $('#_2Select').val();
        var _3 = $('#_3Select').val();
        var _4 = $('#_4Select').val();
        var _5 = $('#_5Select').val();
        var _6 = $('#_6Select').val();
        var _7 = $('#_7Select').val();
        var _8 = $('#_8Select').val();
        var _9 = $('#_9Select').val();
        var _10 = $('#_10Select').val();
        var _11 = $('#_11Select').val();
        var _12 = $('#_12Select').val();
        var _13 = $('#_13Select').val();
        var _14 = $('#_14Select').val();
        var _15 = $('#_15Select').val();
        var _16 = $('#_16Select').val();
        var _17 = $('#_17Select').val();
        var _18 = $('#_18Select').val();
        var _19 = $('#_19Select').val();
        var _20 = $('#_20Select').val();
        var _21 = $('#_21Select').val();
        var _22 = $('#_22Select').val();
        var _23 = $('#_23Select').val();
        var _24 = $('#_24Select').val();
        var _25 = $('#_25Select').val();
        var _26 = $('#_26Select').val();
        var _27 = $('#_27Select').val();
        var _28 = $('#_28Select').val();
        var _29 = $('#_29Select').val();
        var _30 = $('#_30Select').val();
        var _31 = $('#_31Select').val();


        // Buat elemen form baru
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "<?= base_url('save-employee-absen') ?>";

        // Buat elemen input untuk employeeid
        var employeeInput = document.createElement("input");
        employeeInput.type = "hidden";
        employeeInput.name = "employeeid";
        employeeInput.value = employeeid;
        form.appendChild(employeeInput);

        // Buat elemen input untuk jobid
        var jobInput = document.createElement("input");
        jobInput.type = "hidden";
        jobInput.name = "jobid";
        jobInput.value = jobid;
        form.appendChild(jobInput);

        // Buat elemen input untuk period
        var periodInput = document.createElement("input");
        periodInput.type = "hidden";
        periodInput.name = "period";
        periodInput.value = period;
        form.appendChild(periodInput);

        // Buat elemen input untuk checkedDays sebagai array
        var __1 = document.createElement("input");
        __1.type = "hidden";
        __1.name = "_1";
        __1.value = _1;
        form.appendChild(__1);

        var __2 = document.createElement("input");
        __2.type = "hidden";
        __2.name = "_2";
        __2.value = _2;
        form.appendChild(__2);

        var __3 = document.createElement("input");
        __3.type = "hidden";
        __3.name = "_3";
        __3.value = _3;
        form.appendChild(__3);

        var __4 = document.createElement("input");
        __4.type = "hidden";
        __4.name = "_4";
        __4.value = _4;
        form.appendChild(__4);

        var __5 = document.createElement("input");
        __5.type = "hidden";
        __5.name = "_5";
        __5.value = _5;
        form.appendChild(__5);

        var __6 = document.createElement("input");
        __6.type = "hidden";
        __6.name = "_6";
        __6.value = _6;
        form.appendChild(__6);

        var __7 = document.createElement("input");
        __7.type = "hidden";
        __7.name = "_7";
        __7.value = _7;
        form.appendChild(__7);

        var __8 = document.createElement("input");
        __8.type = "hidden";
        __8.name = "_8";
        __8.value = _8;
        form.appendChild(__8);

        var __9 = document.createElement("input");
        __9.type = "hidden";
        __9.name = "_9";
        __9.value = _9;
        form.appendChild(__9);

        var __10 = document.createElement("input");
        __10.type = "hidden";
        __10.name = "_10";
        __10.value = _10;
        form.appendChild(__10);

        var __11 = document.createElement("input");
        __11.type = "hidden";
        __11.name = "_11";
        __11.value = _11;
        form.appendChild(__11);

        var __12 = document.createElement("input");
        __12.type = "hidden";
        __12.name = "_12";
        __12.value = _12;
        form.appendChild(__12);

        var __13 = document.createElement("input");
        __13.type = "hidden";
        __13.name = "_13";
        __13.value = _13;
        form.appendChild(__13);

        var __14 = document.createElement("input");
        __14.type = "hidden";
        __14.name = "_14";
        __14.value = _14;
        form.appendChild(__14);

        var __15 = document.createElement("input");
        __15.type = "hidden";
        __15.name = "_15";
        __15.value = _15;
        form.appendChild(__15);

        var __16 = document.createElement("input");
        __16.type = "hidden";
        __16.name = "_16";
        __16.value = _16;
        form.appendChild(__16);

        var __17 = document.createElement("input");
        __17.type = "hidden";
        __17.name = "_17";
        __17.value = _17;
        form.appendChild(__17);

        var __18 = document.createElement("input");
        __18.type = "hidden";
        __18.name = "_18";
        __18.value = _18;
        form.appendChild(__18);

        var __19 = document.createElement("input");
        __19.type = "hidden";
        __19.name = "_19";
        __19.value = _19;
        form.appendChild(__19);

        var __20 = document.createElement("input");
        __20.type = "hidden";
        __20.name = "_20";
        __20.value = _20;
        form.appendChild(__20);

        var __21 = document.createElement("input");
        __21.type = "hidden";
        __21.name = "_21";
        __21.value = _21;
        form.appendChild(__21);

        var __22 = document.createElement("input");
        __22.type = "hidden";
        __22.name = "_22";
        __22.value = _22;
        form.appendChild(__22);

        var __23 = document.createElement("input");
        __23.type = "hidden";
        __23.name = "_23";
        __23.value = _23;
        form.appendChild(__23);

        var __24 = document.createElement("input");
        __24.type = "hidden";
        __24.name = "_24";
        __24.value = _24;
        form.appendChild(__24);

        var __25 = document.createElement("input");
        __25.type = "hidden";
        __25.name = "_25";
        __25.value = _25;
        form.appendChild(__25);

        var __26 = document.createElement("input");
        __26.type = "hidden";
        __26.name = "_26";
        __26.value = _26;
        form.appendChild(__26);

        var __27 = document.createElement("input");
        __27.type = "hidden";
        __27.name = "_27";
        __27.value = _27;
        form.appendChild(__27);

        var __28 = document.createElement("input");
        __28.type = "hidden";
        __28.name = "_28";
        __28.value = _28;
        form.appendChild(__28);

        var __29 = document.createElement("input");
        __29.type = "hidden";
        __29.name = "_29";
        __29.value = _29;
        form.appendChild(__29);

        var __30 = document.createElement("input");
        __30.type = "hidden";
        __30.name = "_30";
        __30.value = _30;
        form.appendChild(__30);

        var __31 = document.createElement("input");
        __31.type = "hidden";
        __31.name = "_31";
        __31.value = _31;
        form.appendChild(__31);

        // Tambahkan form ke dokumen dan kirimkan
        document.body.appendChild(form);
        form.submit();
        // Refresh halaman setelah 2 detik (jika berhasil)
    }
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var checkbox = document.getElementById("_1Select");

    checkbox.addEventListener("change", function() {
        if (this.checked) {
            this.value = 1;
        } else {
            this.value = 0;
        }
    });
});
</script>



        </div>
    </div>
</div>
