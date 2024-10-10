@extends('layouts.admin.master')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">

    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Create Product</h5>
        <small class="text-muted float-end">Product</small>
      </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card-body">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" onsubmit="removeFormatAndSubmit(this)">
            @csrf <!-- Token CSRF wajib di Laravel -->
        
        <!-- Input untuk Nama Produk -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="name">Product Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="name" placeholder="Product Name" value="{{ old('name') }}" />
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Dropdown untuk Kategori Produk -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="category_id">Category</label>
            <div class="col-sm-10">
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Input untuk Stok Produk -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="stock">Stock</label>
            <div class="col-sm-10">
                <input type="number" name="stock" class="form-control" id="stock" placeholder="Stock" value="{{ old('stock') }}" />
                @error('stock') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="description">Description</label>
            <div class="col-sm-10">
                <textarea name="description" class="form-control" id="description" placeholder="Product Description">{{ old('description') }}</textarea>
                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Input untuk Harga Produk -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="price">Price</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="price" class="form-control" id="price" placeholder="Product Price" value="{{ old('price') }}" oninput="formatNumber(this)" />
                </div>
                @error('price') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>


        <!-- Checkbox untuk Is Discount -->
        <div class="row mb-3 d-flex justify-content-center">
            <!-- Checkbox for Is Discount -->
            <div class="col-sm-4 d-flex justify-content-center">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_discount" id="is_discount" value="1" 
                           {{ old('is_discount') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_discount">Diskon</label>
                </div>
            </div>
        
            <!-- Checkbox for Is Pre-Order -->
            <div class="col-sm-4 d-flex justify-content-center">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_pre_order" id="is_pre_order" value="1" 
                           {{ old('is_pre_order') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_pre_order">Apakah Pre Order?</label>
                </div>
            </div>
        
            <!-- Checkbox for Is Negotiable -->
            <div class="col-sm-4 d-flex justify-content-center">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_negotiable" id="is_negotiable" value="1" 
                           {{ old('is_negotiable') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_negotiable">Apakah Bisa Nego?</label>
                </div>
            </div>
        </div>
        
        


        <!-- Input untuk Harga Diskon (Opsional) -->
        <div class="row mb-3" id="discount-price-wrapper" style="display: none;">
            <label class="col-sm-2 col-form-label" for="discount_price">Discount Price</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="discount_price" class="form-control" id="discount_price" placeholder="Discount Price" value="{{ old('discount_price') }}" oninput="formatNumber(this)" />
                </div>
                @error('discount_price') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>



        <script>
            function formatNumber(input) {
    // Menghapus karakter selain angka
    let value = input.value.replace(/[^0-9]/g, '');
    
    // Menambahkan titik setiap 3 angka
    input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Fungsi untuk menghapus format titik sebelum submit
function removeFormatAndSubmit(form) {
    const priceInput = document.getElementById('price');
    const discountPriceInput = document.getElementById('discount_price');

    // Menghapus semua titik untuk mengembalikan ke format numerik
    priceInput.value = priceInput.value.replace(/\./g, '');
    
    if (discountPriceInput) {
        discountPriceInput.value = discountPriceInput.value.replace(/\./g, '');
    }

    // Kirim form
    form.submit();
}

        </script>


        <!-- Input untuk Gambar Produk (multiple) -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="images">Product Images</label>
            <div class="col-sm-10">
                <input type="file" name="images[]" class="form-control" id="images" multiple />
                @error('images') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Input untuk Video Produk (Opsional) -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="video">Product Video (Optional)</label>
            <div class="col-sm-10">
                <input type="file" name="video" class="form-control" id="video" />
                @error('video') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="row justify-content-end">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Create Product</button>
            </div>
        </div>
    </form>
</div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // Tampilkan harga diskon jika is_discount diaktifkan
    $('#is_discount').on('change', function() {
        if ($(this).is(':checked')) {
            $('#discount-price-wrapper').show();
        } else {
            $('#discount-price-wrapper').hide();
        }
    });

    // Pastikan tampilan sesuai dengan status saat halaman dimuat
    $(document).ready(function() {
        if ($('#is_discount').is(':checked')) {
            $('#discount-price-wrapper').show();
        }
    });
</script>



@endsection
