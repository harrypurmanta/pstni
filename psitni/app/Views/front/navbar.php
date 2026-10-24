<?php
$session = \Config\Services::session();
$request = \Config\Services::request();
$seg1 = $request->uri->getSegment(1);
$seg2 = $request->uri->getSegment(2);
$isExam = ($seg1 === "tryout" && $seg2 !== "hasiltryout");
?>
<style>
/* Modern Navbar Styles */
.skin-blue .main-header .navbar {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%) !important;
    border: none !important;
    box-shadow: 0 4px 18px rgba(30, 58, 138, 0.18) !important;
    min-height: 64px;
    padding: 0 12px;
}

.main-header .navbar-brand-custom {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    text-decoration: none !important;
    color: #ffffff !important;
    float: left;
    height: 64px;
}

.brand-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.16);
    border: 1px solid rgba(255, 255, 255, 0.28);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 19px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.brand-text {
    display: flex;
    flex-direction: column;
    justify-content: center;
    line-height: 1.25;
}

.brand-title {
    font-size: 15px;
    font-weight: 800;
    letter-spacing: -0.2px;
    color: #ffffff;
}

.brand-subtitle {
    font-size: 11.5px;
    font-weight: 500;
    color: #bfdbfe;
    letter-spacing: 0.3px;
}

/* Nav links */
.custom-nav-list {
    margin: 0;
    padding: 0;
}

.custom-nav-list > li > a {
    color: rgba(255, 255, 255, 0.88) !important;
    font-weight: 600 !important;
    font-size: 13.5px !important;
    padding: 8px 16px !important;
    margin: 14px 4px !important;
    border-radius: 8px !important;
    display: inline-flex !important;
    align-items: center;
    gap: 7px;
    transition: all 0.2s ease !important;
    background: transparent !important;
}

.custom-nav-list > li > a:hover {
    color: #ffffff !important;
    background: rgba(255, 255, 255, 0.15) !important;
    transform: translateY(-1px);
}

.custom-nav-list > li.active > a,
.custom-nav-list > li.active > a:focus,
.custom-nav-list > li.active > a:hover {
    color: #ffffff !important;
    background: rgba(255, 255, 255, 0.25) !important;
    font-weight: 700 !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

/* Toggle button */
.custom-navbar-toggle {
    border: 1px solid rgba(255, 255, 255, 0.25) !important;
    background: rgba(255, 255, 255, 0.12) !important;
    color: #ffffff !important;
    border-radius: 8px !important;
    padding: 9px 12px !important;
    margin-top: 14px !important;
    margin-right: 12px !important;
}

.custom-navbar-toggle:hover {
    background: rgba(255, 255, 255, 0.2) !important;
}

/* User Menu */
.navbar-custom-menu {
    float: right;
    height: 64px;
    display: flex;
    align-items: center;
}

.user-pill-btn {
    display: inline-flex !important;
    align-items: center;
    gap: 9px;
    background: rgba(255, 255, 255, 0.12) !important;
    border: 1px solid rgba(255, 255, 255, 0.22) !important;
    border-radius: 30px !important;
    padding: 6px 14px !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    font-size: 13px !important;
    margin: 12px 6px !important;
    transition: all 0.2s ease !important;
}

.user-pill-btn:hover,
.user-pill-btn:focus,
.open > .user-pill-btn {
    background: rgba(255, 255, 255, 0.22) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.user-pill-btn .user-image {
    width: 28px !important;
    height: 28px !important;
    margin: 0 !important;
    border: 2px solid rgba(255, 255, 255, 0.7);
}

/* Custom Dropdown Menu */
.custom-user-dropdown {
    border-radius: 14px !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.15) !important;
    overflow: hidden !important;
    min-width: 260px !important;
    padding: 0 !important;
    margin-top: 6px !important;
}

.custom-dropdown-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%) !important;
    padding: 20px 16px !important;
    text-align: center;
}

.custom-dropdown-header img {
    border: 3px solid rgba(255, 255, 255, 0.35);
    width: 70px;
    height: 70px;
}

.dropdown-user-name {
    color: #ffffff !important;
    font-size: 15px !important;
    font-weight: 700;
    margin-top: 10px !important;
    margin-bottom: 0 !important;
}

.dropdown-user-sub {
    display: block;
    color: #bfdbfe !important;
    font-size: 12px !important;
    margin-top: 4px;
}

.custom-dropdown-footer {
    background: #f8fafc !important;
    padding: 12px 16px !important;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.btn-custom-profile {
    border-radius: 8px !important;
    font-weight: 600 !important;
    font-size: 12.5px !important;
    padding: 7px 14px !important;
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #334155 !important;
    transition: all 0.2s ease !important;
}

.btn-custom-profile:hover {
    background: #f1f5f9 !important;
    color: #0f172a !important;
}

.btn-custom-logout {
    border-radius: 8px !important;
    font-weight: 600 !important;
    font-size: 12.5px !important;
    padding: 7px 14px !important;
    background: #ef4444 !important;
    border: 1px solid #dc2626 !important;
    color: #ffffff !important;
    transition: all 0.2s ease !important;
}

.btn-custom-logout:hover {
    background: #dc2626 !important;
    color: #ffffff !important;
}

/* Mobile Responsive */
@media (max-width: 767px) {
    .skin-blue .main-header .navbar {
        min-height: 60px;
        padding: 0 4px;
    }
    .main-header .navbar-brand-custom {
        height: 60px;
        padding: 8px 8px;
        max-width: calc(100% - 130px);
    }
    .brand-title {
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .brand-subtitle {
        font-size: 10px;
    }
    .brand-icon {
        width: 32px;
        height: 32px;
        font-size: 16px;
    }
    .navbar-custom-menu {
        height: 60px;
    }
    .user-pill-btn {
        margin: 12px 2px !important;
        padding: 5px 8px !important;
    }
    .user-pill-btn .user-name-label {
        display: none !important;
    }
    .navbar-collapse {
        background: #1e3a8a !important;
        border-top: 1px solid rgba(255, 255, 255, 0.12) !important;
        padding: 8px 15px !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2) !important;
    }
    .custom-nav-list > li > a {
        margin: 4px 0 !important;
        padding: 10px 14px !important;
    }
}
</style>

<nav class="navbar navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="<?= base_url() ?>" class="navbar-brand-custom">
                <div class="brand-icon">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-title">Simulasi CAT Psikologi</span>
                    <span class="brand-subtitle">Bintang Timur Prestasi</span>
                </div>
            </a>
            <button type="button" class="navbar-toggle collapsed custom-navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>

        <?php if (!$isExam): ?>
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav custom-nav-list">
                    <li class="<?= ($seg1 === 'home' || empty($seg1)) ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>/home">
                            <i class="fa fa-home"></i> Home
                        </a>
                    </li>
                    <li class="<?= ($seg1 === 'materi' && $seg2 !== 'pauli') ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>/materi">
                            <i class="fa fa-book"></i> Materi
                        </a>
                    </li>
                    <li class="<?= ($seg1 === 'materi' && $seg2 === 'pauli') ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>/materi/pauli">
                            <i class="fa fa-pencil-square-o"></i> Pauli
                        </a>
                    </li>
                    <li class="<?= ($seg1 === 'keswa') ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>/keswa">
                            <i class="fa fa-heartbeat"></i> Keswa
                        </a>
                    </li>
                </ul>
            </div>
        <?php else: ?>
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav custom-nav-list">
                    <li>
                        <a href="<?= base_url() ?>">
                            <i class="fa fa-home"></i> Home
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle user-pill-btn" data-toggle="dropdown">
                        <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs user-name-label"><?= esc($session->person_nm ?? 'Peserta') ?></span>
                        <i class="fa fa-angle-down" style="font-size: 11px; margin-left: 3px;"></i>
                    </a>
                    <ul class="dropdown-menu custom-user-dropdown">
                        <li class="user-header custom-dropdown-header">
                            <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                            <p class="dropdown-user-name">
                                <?= esc($session->person_nm ?? 'Peserta') ?>
                                <small class="dropdown-user-sub">
                                    <?= esc($session->satuan ?? '') ?> <?= !empty($session->birth_dttm) ? ' • ' . esc($session->birth_dttm) : '' ?>
                                </small>
                            </p>
                        </li>
                        <li class="user-footer custom-dropdown-footer">
                            <a href="<?= base_url() ?>/profile" class="btn btn-default btn-custom-profile">
                                <i class="fa fa-user"></i> Profile
                            </a>
                            <a href="<?= base_url() ?>/login/logout" class="btn btn-danger btn-custom-logout">
                                <i class="fa fa-sign-out"></i> Keluar
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>