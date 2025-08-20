<footer class="footer bg-dark text-light pt-5 pb-4">
    <div class="container position-relative">
        <!-- Hình minh họa (tuỳ chọn) -->
        <!-- <div class="d-none d-lg-block position-absolute end-0 bottom-0 opacity-25">
            <img src="/client/images/giay5-Photoroom.png" alt="Sofa" class="img-fluid" style="max-width: 260px;">
        </div> -->

        <!-- Đăng ký nhận tin -->
        <div class="row align-items-center g-4 mb-5">
            <div class="col-lg-6">
                <h3 class="h5 mb-2 d-flex align-items-center">
                    <img src="/client/images/envelope-outline.svg" alt="" class="me-2" style="width:28px;height:28px;">
                    Đăng ký nhận bản tin
                </h3>
                <p class="text-secondary mb-0">Nhận ưu đãi độc quyền & cập nhật mẫu mới mỗi tuần.</p>
            </div>
            <div class="col-lg-6">
                <form action="#" method="post" class="row g-2" novalidate>
                    <!-- Nếu dùng Laravel, mở comment và thêm @csrf -->
                    <!-- @csrf -->
                    <div class="col-12 col-sm">
                        <input type="text" class="form-control form-control-lg" name="name" placeholder="Họ và tên">
                    </div>
                    <div class="col-12 col-sm">
                        <input type="email" class="form-control form-control-lg" name="email"
                            placeholder="Email của bạn">
                    </div>
                    <div class="col-12 col-sm-auto">
                        <button class="btn btn-primary btn-lg w-100">
                            <i class="fa fa-paper-plane me-2"></i>Đăng ký
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Khối liên kết & thông tin -->
        <div class="row g-4 g-lg-5 mb-4">
            <div class="col-lg-4">
                <a href="/" class="d-inline-flex align-items-center text-decoration-none mb-3">
                    <span class="fs-3 fw-bold text-white">ShopSieuReOk<span class="text-primary">.</span></span>
                </a>
                <p class="text-secondary mb-3">
                    Phong cách tối giản cho bước chân hiện đại. Bền bỉ, thoải mái, cùng bạn bứt phá mỗi ngày.
                </p>
                <ul class="list-unstyled d-flex gap-3 mb-0">
                    <li><a class="text-secondary hover-opacity" href="#" aria-label="Facebook"><i
                                class="fa-brands fa-facebook-f fa-lg"></i></a></li>
                    <li><a class="text-secondary hover-opacity" href="#" aria-label="Instagram"><i
                                class="fa-brands fa-instagram fa-lg"></i></a></li>
                    <li><a class="text-secondary hover-opacity" href="#" aria-label="TikTok"><i
                                class="fa-brands fa-tiktok fa-lg"></i></a></li>
                    <li><a class="text-secondary hover-opacity" href="#" aria-label="LinkedIn"><i
                                class="fa-brands fa-linkedin fa-lg"></i></a></li>
                </ul>
            </div>

            <div class="col-lg-8">
                <div class="row links-wrap">
                    <div class="col-6 col-sm-6 col-md-3">
                        <h6 class="text-white mb-3">Về ShopSieuReOk</h6>
                        <ul class="list-unstyled">
                            <li><a class="footer-link" href="#">Giới thiệu</a></li>
                            <li><a class="footer-link" href="#">Dịch vụ</a></li>
                            <li><a class="footer-link" href="#">Tin tức</a></li>
                            <li><a class="footer-link" href="#">Liên hệ</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <h6 class="text-white mb-3">Hỗ trợ</h6>
                        <ul class="list-unstyled">
                            <li><a class="footer-link" href="#">Trung tâm trợ giúp</a></li>
                            <li><a class="footer-link" href="#">Câu hỏi thường gặp</a></li>
                            <li><a class="footer-link" href="#">Bảo hành & đổi trả</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <h6 class="text-white mb-3">Tuyển dụng</h6>
                        <ul class="list-unstyled">
                            <li><a class="footer-link" href="#">Vị trí đang tuyển</a></li>
                            <li><a class="footer-link" href="#">Đội ngũ</a></li>
                            <li><a class="footer-link" href="#">Chính sách bảo mật</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <h6 class="text-white mb-3">Danh mục</h6>
                        <ul class="list-unstyled">
                            <li><a class="footer-link" href="#">Nike</a></li>
                            <li><a class="footer-link" href="#">Adidas</a></li>
                            <li><a class="footer-link" href="#">Balenciaga</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-secondary">

        <!-- Bản quyền & điều khoản -->
        <div class="row align-items-center pt-3">
            <div class="col-lg-6">
                <p class="mb-2 mb-lg-0 small text-secondary text-center text-lg-start">
                    Bản quyền &copy; {{ date('Y') }}. Đã đăng ký mọi quyền.
                    Thiết kế bởi <a class="text-decoration-underline text-light" href="https://untree.co">Untree.co</a>.
                    Phân phối bởi <a class="text-decoration-underline text-light"
                        href="https://themewagon.com">ThemeWagon</a>.
                </p>
            </div>
            <div class="col-lg-6">
                <ul class="list-unstyled d-flex justify-content-center justify-content-lg-end gap-4 mb-0 small">
                    <li><a class="footer-link" href="#">Điều khoản sử dụng</a></li>
                    <li><a class="footer-link" href="#">Chính sách bảo mật</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>