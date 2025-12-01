<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .btn-primary {
            background-color: #e0bfb2 !important;
            color: #666666 !important;
            border: none;
            transition: background-color 0.3s ease;
        }


        .nav-tabs {
            border-bottom: 2px solid #e0bfb2;
        }

        .nav-tabs .nav-item {
            margin-right: 5px;
        }

        .nav-tabs .nav-link {
            background-color: #f5e5de;
            /* Warna latar belakang tab */
            border: 1px solid #e0bfb2;
            color: #8b5e4d;
            /* Warna teks */
            border-radius: 8px 8px 0 0;
            /* Membuat sudut atas membulat */
            padding: 10px 15px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .nav-tabs .nav-link:hover {
            background-color: #e0bfb2;
            color: white;
        }

        .nav-tabs .nav-link.active {
            background-color: #e0bfb2 !important;
            color: white;
            border-bottom: 2px solid #d1a89b;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 15px !important;
            margin-bottom: 10px !important;
        }

        .tab-content {
            padding: 0 !important;
        }

        .bg-thead {
            background-color: #f5e0d8 !important;
            color: #666666 !important;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 100 !important;
        }

        .mycontaine {
            font-size: 12px !important;
        }

        /* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
        .mycontaine * {
            font-size: inherit !important;
        }

        .card-header-info {
            background: #f5e0d8;
        }
    </style>

    <?php
    $current_url = current_url();
    $base_url = base_url();
    $uri = str_replace($base_url, '', $current_url);
    $db_oriskin = $this->load->database('oriskin', true);

    $user_id = $this->session->userdata('userid');

    $level = $this->session->userdata('level');

    $query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $user_id . '')->row_array();
    $locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';

    $locationList = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();

    $dateSearch = (isset($_GET['dateSearch']) ? $this->input->get('dateSearch') : date('Y-m-d'));

    $location_id = (isset($_GET['locationId']) ? $this->input->get('locationId') :  $locationList[0]['id']);


    $stock_list = $db_oriskin->query("select a.id as id, c.name as unit, a.ingredientsid as ingredientsid, b.name as ingredients, a.stock as stock, a.locationid as locationid 
                                        from msingredientsstock a inner join msingredients b on a.ingredientsid = b.id inner join msunitingredients c on b.unitid = c.id 
                                        where locationid =  $location_id AND b.isactive = 1")->result_array();
    $stock_listproduct = $db_oriskin->query("select b.id as id, a.name as name, b.productid as productid, b.locationid as locationid, b.stock as stock, b.locationid as locationid from msproduct a inner join msproductstock b on a.id = b.productid where locationid = $location_id")->result_array();
    $actual_list = $db_oriskin->query("select a.id as id, c.name as unit, a.ingredientsid as ingredientsid, b.name as ingredients, a.actual_stock as stock, a.locationid as locationid 
                                        from msingredientsactualstock a inner join msingredients b on a.ingredientsid = b.id inner join msunitingredients c on b.unitid = c.id 
                                        where locationid =  $location_id AND b.isactive = 1")->result_array();
    ?>
</head>

<body>
    <div class="mycontaine">
        
        <div class="card p-2 col-md-7">
            <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                <div class="row g-3">
                    <div class="col-md-9">
                        <div class="">
                            <!-- <label class="form-label mt-2">Location</label> -->
                            <select id="locationId" name="locationId" class="form-control text-uppercase" required="true" aria-required="true">
                                <option value="">Select Branch</option>
                                <?php foreach ($locationList as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= ($location_id == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm top-responsive  btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
        <div>
            <ul class="nav nav-tabs active mt-3">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#mstreatment">SALON STOCK</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#msproduct">RETAIL AND DOCTOR STOCK</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="row gx-4">
                <div class="col-md-12 mt-3">
                    <div class="card-body tab-pane show active" id="mstreatment">
                        <div class="card">
                            <div class="table-wrapper p-4">
                                <div class="table-responsive">
                                    <table id="stock-table" class="table table-striped table-bordered" width="100%">
                                        <thead class="bg-thead">
                                            <tr role="">
                                                <th class="text-center" style="font-weight: bold;">NAME</th>
                                                <th class="text-center" style="font-weight: bold;">STOCK</th>
                                                <th class="text-center" style="font-weight: bold;">STOCK ADD</th>
                                                <th class="text-center" style="font-weight: bold;">UNIT</th>
                                                <th class="text-center" style="font-weight: bold;">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $today = new DateTime();
                                            $startOfMonth = new DateTime($today->format('Y-m-01'));
                                            if (isset($stock_list)) {
                                                foreach ($stock_list as $v) {
                                                    $result = $db_oriskin->query("SELECT ISNULL(stock_add, '') AS stock_add, id
                                                                                    FROM msingredientsstockin
                                                                                    WHERE locationid = '" . $v['locationid'] . "'
                                                                                    AND ingredientsid = '" . $v['ingredientsid'] . "'
                                                                                    AND updatedate = (SELECT MAX(updatedate) 
                                                                                                        FROM msingredientsstockin
                                                                                                        WHERE locationid = '" . $v['locationid'] . "' 
                                                                                                        AND ingredientsid = '" . $v['ingredientsid'] . "')")->row();

                                                    $stock_add = $result->stock_add ?? 0;
                                                    $id = $result->id ?? null;

                                                    $isStartOfMonth = $today->format('Y-m-d') === $startOfMonth->format('Y-m-d');

                                                    echo '<tr>
                                                            <td class="text-center">' . $v['ingredients'] . '</td>
                                                            <td class="text-center">' . $v['stock'] . '</td>
                                                            <td class="text-center">' . $stock_add . '</td>
                                                            <td class="text-center">' . $v['unit'] . '</td>
                                                            <td class="text-center">
                                                                <button class="btn btn-sm btn-info" style="cursor: pointer; " data-toggle="modal" data-target="#stockIngredients"
                                                                    data-ingredients="' . $v['ingredients'] . '"
                                                                    data-ingredientsid="' . $v['ingredientsid'] . '"
                                                                    data-locationid = "' . $location_id . ' "
                                                                    data-userid = "' . $user_id . ' "
                                                                >Add</button>';


                                                    echo '<button class="btn btn-sm btn-success" style="cursor: pointer; " data-toggle="modal" data-target="#stockIngredientsActualInsert"
                                                            data-id="' . $v['ingredientsid'] . '"
                                                            data-ingredients="' . $v['ingredients'] . '"
                                                            data-stock="' . $v['stock'] . '"
                                                        >Stock Awal</button>';



                                                    echo '<button class="btn btn-sm btn-warning" style="cursor: pointer; " data-toggle="modal" data-target="#stockAddIngredientsEdit"
                                                        data-id="' . $id . '"
                                                        data-ingredients="' . $v['ingredients'] . '"
                                                        data-stock="' . $stock_add . '"
                                                    >Edit Stock Add</button>
                                                    </td>
                                                    </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body tab-pane" id="msproduct">
                        <div class="card">
                            <div class="table-wrapper p-4">
                                <div class="table-responsive">
                                    <table id="stockproduct-table" class="table table-bordered" width="100%">
                                        <thead class="bg-thead">
                                            <tr role="">
                                                <th class="text-center" style="font-weight: bold;">NAMA</th>
                                                <th class="text-center" style="font-weight: bold;">STOCK</th>

                                                <th class="text-center" style="font-weight: bold;">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($stock_listproduct)) {
                                                foreach ($stock_listproduct as $v) {
                                                    echo '<tr>
															<td class="text-center">
																' . $v['name'] . '
															</td>

															<td class="text-center">
																' . $v['stock'] . '
															</td>
                    
                                                            <td  class="text-center">
                                                                <button class="btn btn-sm btn-info" style="cursor: pointer; " data-toggle="modal" data-target="#stockProduct"
                                                                    data-name="' . $v['name'] . '"
                                                                    data-productid="' . $v['productid'] . '"
                                                                    data-locationid = "' . $location_id . ' "
                                                                    data-userid = "' . $user_id . ' "
                                                                >Tambah</button>

                                                                <button class="btn btn-sm btn-success" style="cursor: pointer; " data-toggle="modal" data-target="#stockProductEdit"
                                                                    data-id="' . $v['id'] . '"
                                                                    data-name="' . $v['name'] . '"
                                                                    data-stock="' . $v['stock'] . '"
                                                                >Edit</button>
                                                            </td>
														  </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal for Stock Ingredients Actual Insert -->
    <div class="modal fade" id="stockIngredientsActualInsert" tabindex="-1" role="dialog" aria-labelledby="stockIngredientsActualInsertLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockIngredientsActualInsertLabel">INSERT STOCK AWAL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formStockActualInsert" action="<?= base_url('App/insertStockActual') ?>">
                        <input type="hidden" id="ingredientsIdActual" name="ingredientsid">


                        <div class="form-group">
                            <label for="ingredientsNameActual" class="col-form-label">Ingredients</label> <br>
                            <input type="text" class="form-control" id="ingredientsNameActual" name="ingredients" readonly>
                        </div>
                        <div class="form-group">
                            <label for="actualStock" class="col-form-label">Stock Awal</label> <br>
                            <input type="text" class="form-control" id="actualStock" name="actual_stock" required oninput="validateNumberInput(this)">
                        </div>
                        <div class="form-group">
                            <label for="period" class="col-form-label">Periode</label> <br>
                            <input type="month" class="form-control" id="periodActual" name="periodActual" required readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveStockActual()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT STOCK INGREDIENTS -->
    <div class="modal fade" id="stockIngredientsEdit" tabindex="-1" role="dialog" aria-labelledby="stockIngredientsLabelEdit" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockIngredientsLabelEdit">Edit Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="<?= base_url('App/editStockIngredientsUpdate') ?>">

                        <input type="hidden" id="idEdit" name="idEdit">
                        <label for="editIngredientsStock" class="col-form-label">Ingredients</label>

                        <div class="form-group">
                            <label></label>
                            <input id="editIngredientsStock" class="form-control" type="text" disabled readonly>
                        </div>
                        <label for="editQtyStock" class="col-form-label">Jumlah Stock</label>
                        <div class="form-group">
                            <label></label>
                            <input type="text" class="form-control" id="editQtyStock" name="editQtyStock" oninput="validateNumberInput(this)">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveChangesEdit()">Edit Stock</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH STOCK PRODUCT -->
    <div class="modal fade" id="stockProduct" tabindex="-1" role="dialog" aria-labelledby="stockProductLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockProductLabel">Tambah Stock Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="<?= base_url('App/addStockProduct') ?>">
                        <input type="hidden" id="productId" name="productId">
                        <input type="hidden" id="userId" name="userId">
                        <input type="hidden" id="locationId" name="locationId">

                        <label for="productName" class="col-form-label">Product</label>
                        <div class="form-group">
                            <label></label>
                            <input id="productName" class="form-control" type="text">
                        </div>
                        <label for="qtyProduct" class="col-form-label">Jumlah Stock</label>
                        <div class="form-group">
                            <label></label>
                            <input type="text" class="form-control" id="stock_addproduct" name="stock_addproduct" oninput="validateNumberInput(this)">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveChangesProduct()">Tambah Stock</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT STOCK PRODUCT -->
    <div class="modal fade" id="stockProductEdit" tabindex="-1" role="dialog" aria-labelledby="stockProductEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockProductEditLabel">Edit Stock Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="<?= base_url('App/editStockProduct') ?>">
                        <input type="hidden" id="productIdEdit" name="productIdEdit">
                        <label for="editIngredientsStock" class="col-form-label">Product</label>
                        <div class="form-group">
                            <label></label>
                            <input id="productNameEdit" class="form-control" type="text" disabled readonly>
                        </div>
                        <label for="productStock" class="col-form-label">Jumlah Stock</label>
                        <div class="form-group">
                            <label></label>
                            <input type="text" class="form-control" id="productStockEdit" name="productStockEdit" oninput="validateNumberInput(this)">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveChangesEditProduct()">Edit Stock</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="stockAddIngredientsEdit" tabindex="-1" role="dialog" aria-labelledby="stockAddIngredientsLabelEdit" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockAddIngredientsLabelEdit">Edit Stock Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="<?= base_url('App/editStockAddIngredientsUpdate') ?>">

                        <input type="hidden" id="editIdStockAdd" name="editIdStockAdd">
                        <label for="editIngredientsStockAdd" class="col-form-label">Ingredients</label>

                        <div class="form-group">
                            <label></label>
                            <input id="editIngredientsStockAdd" class="form-control" type="text" disabled readonly>
                        </div>
                        <label for="editQtyStockAdd" class="col-form-label">Jumlah Stock</label>
                        <div class="form-group">
                            <label></label>
                            <input type="text" class="form-control" id="editQtyStockAdd" name="editQtyStockAdd" oninput="validateNumberInput(this)">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveChangesEditStockAdd()">Edit
                        Stock</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="stockIngredients" tabindex="-1" role="dialog" aria-labelledby="stockIngredientsLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockIngredientsLabel">TAMBAH STOCK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="<?= base_url('App/editStockIngredients') ?>">
                        <input type="hidden" id="editIngredientsId" name="editIngredientsId">
                        <input type="hidden" id="editLocationId" name="editLocationId">
                        <input type="hidden" id="editUserId" name="editUserId">

                        <label for="editIngredients" class="col-form-label">Ingredients</label>
                        <div class="form-group">
                            <label></label>
                            <input id="editIngredients" class="form-control" type="text">
                        </div>
                        <label for="editQty" class="col-form-label">Jumlah Stock</label>
                        <div class="form-group">
                            <label></label>
                            <input type="text" class="form-control" id="editQty" name="editQty">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveChanges()">Tambah Stock</button>
                </div>
            </div>
        </div>
    </div>

</body>



</html>


<script>
    $(document).ready(function() {
        $('#stock-table, #stockproduct-table').DataTable();
    });

    // FUNGSI ADD STOCK INGREDIENTS
    $(document).ready(function() {
        $('#stockIngredients').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var ingredientsid = button.data('ingredientsid');
            var ingredients = button.data('ingredients');
            var locationid = button.data('locationid')
            var userid = button.data('userid')

            console.log(ingredientsid, ingredients,locationid, userid);
            

            $('#editIngredientsId').val(ingredientsid);
            $('#editIngredients').val(ingredients);
            $('#editLocationId').val(locationid);
            $('#editUserId').val(userid);

        });
    });

    function saveChanges() {
        var ingredientsid = $('#editIngredientsId').val();
        var ingredients = $('#editIngredients').val();
        var qty = $('#editQty').val();
        var locationid = $('#editLocationId').val();
        var userid = $('#editUserId').val();

        $.ajax({
            url: "<?= base_url() . 'App/editStockIngredients' ?>",
            type: 'POST',
            data: {
                ingredientsid: ingredientsid,
                stock_add: qty,
                locationid: locationid,
                userid: userid,
            },
            success: function(response) {
                try {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert(data.success);
                        $('#stockIngredients').modal('hide');
                        location.reload();
                    } else if (data.error) {
                        alert(data.error);
                        $('#stockIngredients').modal('hide');
                        location.reload();
                    }
                } catch (e) {
                    alert('Berhasil menambah stock.');
                    $('#stockIngredients').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }


    // FUNGSI EDIT STOCK INGREDIENTS
    $(document).ready(function() {
        $('#stockIngredientsEdit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var stock = button.data('stock');
            var ingredients = button.data('ingredients');
            var id = button.data('id');

            $('#editIngredientsStock').val(ingredients);
            $('#idEdit').val(id);
            $('#editQtyStock').val(stock);

        });
    });

    function saveChangesEdit() {
        var qty = $('#editQtyStock').val();
        var id = $('#idEdit').val();

        console.log(qty, id);
        $.ajax({
            url: "<?= base_url() . 'App/editStockIngredientsUpdate' ?>",
            type: 'POST',
            data: {
                qty: qty,
                id: id,
            },
            success: function(response) {
                try {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert(data.message);
                        $('#stockIngredientsEdit').modal('hide');
                        location.reload();
                    } else {
                        alert(data.message);
                        $('#stockIngredientsEdit').modal('hide');
                        location.reload();
                    }
                } catch (e) {
                    alert('Berhasil update stock.');
                    $('#stockIngredientsEdit').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }

    // FUNGSI ADD STOCK PRODUCT
    $(document).ready(function() {
        $('#stockProduct').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var name = button.data('name');
            var productid = button.data('productid');
            var locationid = button.data('locationid')
            var userid = button.data('userid')

            console.log(locationid, userid);


            $('#productId').val(productid);
            $('#userId').val(userid);
            $('#locationId').val(locationid);
            $('#productName').val(name);

        });
    });

    function saveChangesProduct() {
        var productid = $('#productId').val();
        var userid = $('#userId').val();
        var locationid = $('#locationId').val();
        var stock_addproduct = $('#stock_addproduct').val();

        $.ajax({
            url: "<?= base_url() . 'App/addStockProduct' ?>",
            type: 'POST',
            data: {
                productid: productid,
                stock_add: stock_addproduct,
                locationid: locationid,
                userid: userid,
            },
            success: function(response) {
                try {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert(data.success);
                        $('#stockProduct').modal('hide');
                        location.reload();
                    } else if (data.error) {
                        alert(data.error);
                        $('#stockProduct').modal('hide');
                        location.reload();
                    }
                } catch (e) {
                    alert('Berhasil menambah stock.');
                    $('#stockProduct').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }


    // FUNGSI EDIT STOCK PRODUCT
    $(document).ready(function() {
        $('#stockProductEdit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var stock = button.data('stock');
            var name = button.data('name');
            var id = button.data('id');

            console.log(name, id);

            $('#productNameEdit').val(name);
            $('#productIdEdit').val(id);
            $('#productStockEdit').val(stock);

        });
    });

    function saveChangesEditProduct() {
        var qty = $('#productStockEdit').val();
        var id = $('#productIdEdit').val();

        console.log(qty, id);

        $.ajax({
            url: "<?= base_url() . 'App/editStockProductUpdate' ?>",
            type: 'POST',
            data: {
                qty: qty,
                id: id,
            },
            success: function(response) {
                try {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert(data.message);
                        $('#stockIngredientsEdit').modal('hide');
                        location.reload();
                    } else {
                        alert(data.message);
                        $('#stockIngredientsEdit').modal('hide');
                        location.reload();
                    }
                } catch (e) {
                    alert('Berhasil update stock.');
                    $('#stockIngredientsEdit').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }

    // FUNGSI EDIT STOCK ADD INGREDIENTS
    $(document).ready(function() {
        $('#stockAddIngredientsEdit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var stock = button.data('stock');
            var ingredients = button.data('ingredients');
            var id = button.data('id');

            $('#editIngredientsStockAdd').val(ingredients);
            $('#editIdStockAdd').val(id);
            $('#editQtyStockAdd').val(stock);

        });
    });

    function saveChangesEditStockAdd() {
        var qty = $('#editQtyStockAdd').val();
        var id = $('#editIdStockAdd').val();

        $.ajax({
            url: "<?= base_url() . 'App/editStockAddIngredientsUpdate' ?>",
            type: 'POST',
            data: {
                qty: qty,
                id: id,
            },
            success: function(response) {
                try {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert(data.message);
                        $('#stockIngredientsAddEdit').modal('hide');
                        location.reload();
                    } else {
                        alert(data.message);
                        $('#stockIngredientsAddEdit').modal('hide');
                        location.reload();
                    }
                } catch (e) {
                    alert('Berhasil update stock add.');
                    $('#stockIngredientsAddEdit').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }

    // ACTUAL ACTION
    $(document).ready(function() {
        $('#stockIngredientsActualInsert').on('show.bs.modal', function(event) {
            var today = new Date();
            var year = today.getFullYear();
            var month = String(today.getMonth() + 1).padStart(2, '0');
            var currentPeriod = year + '-' + month;

            var button = $(event.relatedTarget);
            var ingredientsid = button.data('id');
            var ingredients = button.data('ingredients');
            var stock = button.data('stock');
            var locationid = button.data('locationid');


            $('#ingredientsIdActual').val(ingredientsid);
            $('#ingredientsNameActual').val(ingredients);

            $('#actualStock').val(stock);
            $('#periodActual').val(currentPeriod);
        });
    });

    function saveStockActual() {
        var ingredientsid = $('#ingredientsIdActual').val();
        var qty = $('#actualStock').val();
        var period = $('#periodActual').val();
        var locationId = "<?= htmlspecialchars($location_id, ENT_QUOTES, 'UTF-8') ?>";

        console.log(locationId);
        


        $.ajax({
            url: "<?= base_url() . 'App/insertStockActual' ?>",
            type: 'POST',
            data: {
                ingredientsid: ingredientsid,
                stock_add: qty,
                period: period,
                locationId: locationId,
            },
            success: function(response) {
                try {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert(data.success);
                        $('#stockIngredientsActualInsert').modal('hide');
                        location.reload();
                    } else if (data.error) {
                        alert(data.error);
                        $('#stockIngredientsActualInsert').modal('hide');
                        location.reload();
                    }
                } catch (e) {
                    alert('Berhasil menambah stock.');
                    $('#stockIngredientsActualInsert').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }
</script>


<script>
    function validateNumberInput(input) {
        input.value = input.value
            .replace(/[^0-9.,]/g, '')
            .replace(/,/g, '.')
            .replace(/(\..*)\./g, '$1');
    }
</script>