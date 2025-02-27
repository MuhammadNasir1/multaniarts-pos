<?php include_once 'includes/head.php'; ?>
<?php include_once 'includes/header.php'; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-bg" align="center">

                <div class="row">
                    <div class="col-12 mx-auto h4">
                        <b class="text-center card-text">Cash Book</b>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<div class="card">
    <div class="card-body w-50 mx-auto">
        <form action="cashbook.php" method="post">
            <input type="date" name="date" id="date" class="form-control" required>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mt-2">Check</button>
            </div>
        </form>
    </div>
</div>
<?php include_once 'includes/foot.php'; ?>