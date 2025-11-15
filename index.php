<?php
require_once 'User.php';
require_once 'Sale.php';
require_once 'Commission.php';
require_once 'pagination.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
list($limitValue, $offset) = paginate($page, $limit);

$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'affiliates_page';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    if ($_POST['action'] === 'create_affiliate') {
        $name = trim($_POST['name']);
        $parentId = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;

        User::add($name, $parentId);

        echo json_encode(['success' => true]);
        exit;
    }

    if ($_POST['action'] === 'create_sale') {
        $affiliateId = $_POST['affiliate_id'];
        $amount  = $_POST['amount'];
        $product = $_POST['product'];

        $saleId = Sale::add($affiliateId, $product, $amount);
        Commission::distribute($saleId, $affiliateId, $amount);

        echo json_encode(['success' => true]);
        exit;
    }
}

$users = User::getPaginated($limitValue, $offset);
$totalUsers = User::countAll();
$totalUserPages = totalPages($totalUsers, $limit);

$sales = Sale::getPaginated($limitValue, $offset);
$totalSales = Sale::countAll();
$totalSalePages = totalPages($totalSales, $limit);

$commissions = Commission::getPaginated($limitValue, $offset);
$totalCom = Commission::countAll();
$totalComPages = totalPages($totalCom, $limit);


$allUsers = User::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Affiliate Payout System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .section-page { display: none; }
        .section-page.active { display: block; }
    </style>
</head>
<body class="container py-4">

<h2 class="mb-4">Affiliate Payout System</h2>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a href="?tab=affiliates_page" 
           class="nav-link <?= $activeTab == 'affiliates_page' ? 'active' : '' ?>">
           Affiliates
        </a>
    </li>
    <li class="nav-item">
        <a href="?tab=sales_page" 
           class="nav-link <?= $activeTab == 'sales_page' ? 'active' : '' ?>">
           Sales
        </a>
    </li>
    <li class="nav-item">
        <a href="?tab=commissions_page" 
           class="nav-link <?= $activeTab == 'commissions_page' ? 'active' : '' ?>">
           Commissions
        </a>
    </li>
</ul>

<div id="affiliates_page" class="section-page <?= $activeTab == 'affiliates_page' ? 'active' : '' ?>">

    <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#affiliateModal">
        Create Affiliate
    </button>

    <div class="card mb-3">
        <div class="card-header text-center">Affiliates</div>

        <table class="table table-striped table-sm mb-0">
            <thead>
                <tr>
                    <th>Affiliate</th>
                    <th>Referred By</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <?php 
                        $parentName = $user['parent_id'] 
                            ? User::getName($user['parent_id']) 
                            : 'No Referrer'; 
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($parentName) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalUserPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?tab=affiliates_page&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

</div>

<div id="sales_page" class="section-page <?= $activeTab == 'sales_page' ? 'active' : '' ?>">

    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#saleModal">
        Record Sale
    </button>

    <div class="card mb-3">
        <div class="card-header text-center">Sales</div>

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Affiliate</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
           </thead>
            <tbody>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['name']) ?></td>
                        <td><?= htmlspecialchars($sale['product']) ?></td>
                        <td><?= number_format($sale['amount'], 2) ?></td>
                        <td><?= $sale['sale_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalSalePages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?tab=sales_page&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

    </div>
</div>

<div id="commissions_page" class="section-page <?= $activeTab == 'commissions_page' ? 'active' : '' ?>">

    <div class="card mb-3">
        <div class="card-header text-center">Commissions</div>

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Commission To</th>
                    <th>From Sale By</th>
                    <th>Sale Amount</th>
                    <th>Level</th>
                    <th>Commission</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commissions as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['affiliate_name']) ?></td>
                        <td><?= htmlspecialchars($c['buyer_name']) ?></td>
                        <td><?= number_format($c['sale_amount'], 2) ?></td>
                        <td><?= $c['level'] ?></td>
                        <td><?= number_format($c['commission_amt'], 2) ?></td>
                     </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalComPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?tab=commissions_page&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

    </div>
</div>

<div class="modal" id="affiliateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            <h5>Add New Affiliate</h5>

            <form id="createAffiliateForm">
                <input type="text" class="form-control mb-2" id="affiliateName" placeholder="Affiliate Name" required>

                <select id="parentAffiliate" class="form-select mb-2">
                    <option value="">No Parent</option>
                    <?php foreach ($allUsers  as $user): ?>
                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <button class="btn btn-success" type="submit">Add</button>
            </form>

        </div>
    </div>
</div>

<div class="modal" id="saleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            <h5>Record Sale</h5>

            <form id="createSaleForm">
                <select id="saleAffiliate" class="form-select mb-2" required>
                    <option value="">Select Affiliate</option>
                    <?php foreach ($allUsers  as $user): ?>
                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="text" class="form-control mb-2" id="saleProduct" placeholder="Product Name" required>

                <input type="number" class="form-control mb-2" id="saleAmount" step="0.01" min="0.01" placeholder="Amount" required>

                <button class="btn btn-primary" type="submit">Record Sale</button>
            </form>
        </div>
    </div>
</div>

<div id="responseAlert" class="alert alert-success text-center" 
     style="display:none; position:fixed; top:20px; left:50%; transform:translateX(-50%); z-index:9999;">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
    $('#createAffiliateForm').on('submit', function (e) {
        e.preventDefault();

        $.post('index.php', {
            action: 'create_affiliate',
            name: $('#affiliateName').val(),
            parent_id: $('#parentAffiliate').val()
        }, function (res) {
            if (res.success) {
                $('#responseAlert').text("Affiliate created successfully!").show();
                setTimeout(() => location.reload(), 1500);
            }
        }, 'json');
    });

    $('#createSaleForm').on('submit', function (e) {
        e.preventDefault();

        $.post('index.php', {
            action: 'create_sale',
            affiliate_id: $('#saleAffiliate').val(),
            product: $('#saleProduct').val(),
            amount: $('#saleAmount').val()
        }, function (res) {
            if (res.success) {
                $('#responseAlert').text("Sale recorded successfully!").show();
                setTimeout(() => location.reload(), 1500);
            }
        }, 'json');
    });
</script>

</body>
</html>
