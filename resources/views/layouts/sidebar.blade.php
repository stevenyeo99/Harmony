<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-cash-register"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Harmony</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Beranda</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ isset($invoiceActive) ? $invoiceActive : '' }}">
        <a class="nav-link" href="{{ route('manage.invoice') }}">
            <i class="fas fa-fw fa-shopping-basket"></i>
            <span>Penjualan</span>
        </a>
    </li>

    @if(Gate::allows('is-admin'))
        <li class="nav-item {{ isset($purchaseActive) ? $purchaseActive : '' }}">
            <a class="nav-link" href="{{ route('manage.purchase') }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Pembelian</span>
            </a>
        </li>
    @endif

    @if(Gate::allows('is-admin'))
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Modul
        </div>

        <li class="nav-item {{ isset($itemActive) ? $itemActive : ''}}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseItem" aria-expanded="true" aria-controls="collapseItem">
                <i class="fas fa-box"></i>
                <span>Item</span>
            </a>
            
            <div id="collapseItem" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ isset($itemDetailActive) ? $itemDetailActive : ''}}" href="{{ route('manage.item.detail') }}">Item</a>
                    <a class="collapse-item {{ isset($itemCategoryActive) ? $itemCategoryActive : ''}}" href="{{ route('manage.item.category') }}">Kategori</a>
                    <a class="collapse-item {{ isset($itemUnitActive) ? $itemUnitActive : ''}}" href="{{ route('manage.item.unit') }}">Unit</a>
                </div>
            </div>
        </li>

        <li class="nav-item {{ isset($supplierActive) ? $supplierActive : '' }}">
            <a class="nav-link" href="{{ route('manage.supplier') }}">
                <i class="fas fa-address-book"></i>
                <span>Supplier</span>
            </a>
        </li>
    @endif

    @if(Gate::allows('is-boss'))
        <li class="nav-item {{ isset($userActive) ? $userActive : ''}}">
            <a class="nav-link" href="{{ route('manage.user') }}">
                <i class="fas fa-users"></i>
                <span>User</span>
            </a>
        </li>
    @endif

    

    @if(Gate::allows('is-admin'))
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Laporan
        </div>

        <li class="nav-item {{ isset($transactionReportActive) ? $transactionReportActive : ''}}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseItem2" aria-expanded="true" aria-controls="collapseItem2">
                <i class="fas fa-chart-line"></i>
                <span>Transaksi</span>
            </a>
        
            <div id="collapseItem2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ isset($transactionItemReportActive) ? $transactionItemReportActive : ''}}" href="{{ route('manage.report.itemReportIndex') }}">
                        Item
                    </a>
                    
                    <a class="collapse-item {{ isset($transactionPurchaseReportActive) ? $transactionPurchaseReportActive : ''}}" href="{{ route('manage.report.purchaseReportIndex') }}">
                        Pembelian
                    </a>

                    <a class="collapse-item {{ isset($transactionInvoiceReportActive) ? $transactionInvoiceReportActive : ''}}" href="{{ route('manage.report.invoiceReportIndex') }}">
                        Penjualan
                    </a>
                </div>
            </div>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>