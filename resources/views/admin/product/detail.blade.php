@extends('admin.layout.master')

@section('title')
    Chi tiết sản phẩm
@endsection

@section('content')
    <div class="bg-light rounded p-4">
        <div class="row">
            <div class="table-reponsive">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2" class="text-center">
                            Ảnh
                        </th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <div class="position-relative">
                                        <img src="{{ asset('client/img/photos/giày-thể-thao-nam-mới-nhất-2-1.jpg') }}"
                                        width="300" alt="" class="img-fluid">
                                    <button type="button"
                                        class="btn text-secondary btn-sm position-absolute top-0 start-100 translate-middle">
                                        <i class="fas fa-trash-alt fa-lg" title="Xóa ảnh"></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="uploadImage"
                                        class="btn btn-outline-primary d-flex flex-column align-items-center py-3 mb-2">
                                        <i class="fas fa-upload"></i>
                                        <span>Tải ảnh lên</span>
                                    </label>
                                    <input multiple hidden type="file" id="uploadImage"
                                        class="custom-file-input form-control">
                                </div>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Danh mục
                        <td></td>
                    </tr>
                    <tr>
                        <th>Thương hiệu</th>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("uploadImage").addEventListener("change", function () {
            let fileCount = this.files.length;
            let displayText = fileCount > 0 ? fileCount + " tệp" : "Chọn ảnh";

            document.querySelector("label[for='uploadImage'] span").textContent = displayText;
        });

    </script>

@endsection