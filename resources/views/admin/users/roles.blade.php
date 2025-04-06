@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Phân quyền người dùng</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Danh sách vai trò</h3>
                                    <div class="card-tools">
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addRoleModal">
                                            <i class="bi bi-plus"></i> Thêm vai trò
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Tên vai trò</th>
                                                <th>Mô tả</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Quản trị viên</td>
                                                <td>Toàn quyền truy cập hệ thống</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Sửa</button>
                                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Người dùng</td>
                                                <td>Quyền truy cập cơ bản</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Sửa</button>
                                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Danh sách quyền</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="manageProducts">
                                            <label for="manageProducts" class="custom-control-label">Quản lý sản phẩm</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="manageCategories">
                                            <label for="manageCategories" class="custom-control-label">Quản lý danh mục</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="manageUsers">
                                            <label for="manageUsers" class="custom-control-label">Quản lý người dùng</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="viewStatistics">
                                            <label for="viewStatistics" class="custom-control-label">Xem thống kê</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">Thêm vai trò mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="roleName">Tên vai trò</label>
                        <input type="text" class="form-control" id="roleName" placeholder="Nhập tên vai trò">
                    </div>
                    <div class="form-group">
                        <label for="roleDescription">Mô tả</label>
                        <textarea class="form-control" id="roleDescription" rows="3" placeholder="Nhập mô tả vai trò"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>
@endsection 