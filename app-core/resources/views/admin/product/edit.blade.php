@extends('layouts.admin.master')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">

        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Product</h5>
            <small class="text-muted float-end">{{ $product->name }}</small>
          </div>
    
          <div class="card-body">

    <!-- Form untuk mengedit produk -->
    <form action="{{ route('product.update', $product->slug) }}" method="POST" enctype="multipart/form-data" onsubmit="removeFormatAndSubmit(this)">
        @csrf
        @method('PUT') <!-- Menggunakan PUT untuk update data -->
        
        <!-- Input untuk Nama Produk -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="name">Product Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="name" placeholder="Product Name" value="{{ old('name', $product->name) }}" />
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="status_published">Status</label>
            <div class="col-sm-10">
                <select name="status_published" class="form-control">
                    <option value="" disabled>Select Status</option>
                    <option value="Published" {{ old('status_published', $product->status_published) == 'Published' ? 'selected' : '' }}>
                        Published
                    </option>
                    <option value="Unpublished" {{ old('status_published', $product->status_published) == 'Unpublished' ? 'selected' : '' }}>
                        Unpublished
                    </option>
                </select>
                @error('status_published') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        

        <!-- Dropdown untuk Kategori Produk -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="category_id">Category</label>
            <div class="col-sm-10">
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                <input type="number" name="stock" class="form-control" id="stock" placeholder="Stock" value="{{ old('stock', $product->stock) }}" />
                @error('stock') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Input untuk Deskripsi Produk -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="description">Description</label>
            <div class="col-sm-10">
                <textarea name="description" class="form-control" id="description" placeholder="Product Description">{{ old('description', $product->description) }}</textarea>
                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

<!-- Froala Editor CSS & JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.8/css/froala_editor.pkgd.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.8/js/froala_editor.pkgd.min.js"></script>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="specification">Specification</label>
    <div class="col-sm-10">
        <!-- Textarea untuk menampung nilai spesifikasi dari database -->
        <textarea name="specification" class="form-control" id="specification" placeholder="Product specification">{{ old('specification', $product->specification) }}</textarea>
        @error('specification') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
</div>

<!-- Inisialisasi Froala Editor -->
<script>
  new FroalaEditor('#specification', {
    height: 300
  });
</script>


        <!-- Input untuk Harga Produk -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="price">Price</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="price" class="form-control" id="price" placeholder="Product Price" value="{{ old('price', number_format($product->price, 0, '', '.')) }}" oninput="formatNumber(this)" />
                </div>
                @error('price') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        

        <div class="row mb-3">
            <!-- Checkbox for Is Discount -->
            <div class="col-sm-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_discount" id="is_discount" value="1" 
                           {{ old('is_discount', $product->discount_price ? '1' : '0') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_discount">Diskon</label>
                </div>
            </div>
        
            <!-- Checkbox for Is Pre-Order -->
            <div class="col-sm-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_pre_order" id="is_pre_order" value="1" 
                           {{ old('is_pre_order', $product->is_pre_order) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_pre_order">Apakah Pre Order?</label>
                </div>
            </div>
        
            <!-- Checkbox for Is Negotiable -->
            <div class="col-sm-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_negotiable" id="is_negotiable" value="1" 
                           {{ old('is_negotiable', $product->is_negotiable) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_negotiable">Apakah Bisa Nego?</label>
                </div>
            </div>
        </div>

<!-- Input for Discount Price (Optional) -->
<div class="row mb-3" id="discount-price-wrapper" style="display: {{ old('is_discount', $product->discount_price ? '1' : '0') ? 'block' : 'none' }};">
    <label class="col-sm-2 col-form-label" for="discount_price">Discount Price</label>
    <div class="col-sm-10">
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="text" name="discount_price" class="form-control" id="discount_price" placeholder="Discount Price" value="{{ old('discount_price', number_format($product->discount_price, 0, ',', '.')) }}" oninput="formatNumber(this)" />
        </div>
        @error('discount_price') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
</div>

        

        <!-- Menampilkan Gambar Produk yang Sudah Ada -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Current Images</label>
            <div class="col-sm-10">
                <div class="row">
                    @foreach($product->images as $image)
                        <div class="col-md-3 mb-3" id="image-{{ $image->id }}">
                            <img src="{{ asset($image->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            <!-- Opsi jika ingin menghapus gambar -->
                            <button type="button" class="btn btn-sm btn-danger mt-2 delete-image" data-id="{{ $image->id }}">
                                Delete Image
                            </button>                           
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Input untuk Mengunggah Gambar Baru (multiple) -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="images">New Product Images (Optional)</label>
            <div class="col-sm-10">
                <input type="file" name="images[]" class="form-control" id="images" multiple />
                @error('images') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Menampilkan Video Produk yang Sudah Ada (jika ada) -->
        @if($product->videos->isNotEmpty())
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Current Videos</label>
                <div class="col-sm-10">
                    @foreach($product->videos as $video)
                        <div class="mb-3" id="video-{{ $video->id }}">
                            <video width="320" height="240" controls>
                                <source src="{{ asset($video->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <!-- Opsi jika ingin menghapus video -->
                            <button type="button" class="btn btn-sm btn-danger mt-2 delete-video" data-id="{{ $video->id }}">
                                Delete Video
                            </button>                           
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Current Videos</label>
                <div class="col-sm-10">
                    <p>Tidak ada video pada produk ini</p>
                </div>
            </div>
        @endif
    


        <!-- Input untuk Mengunggah Video Baru (Optional) -->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="video">New Product Video (Optional)</label>
            <div class="col-sm-10">
                <input type="file" name="video" class="form-control" id="video" />
                @error('video') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="row justify-content-end">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </div>
    </div>
    </form>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDiscountCheckbox = document.getElementById('is_discount');
        const discountPriceWrapper = document.getElementById('discount-price-wrapper');
        const discountPriceField = document.getElementById('discount_price');

        // Toggle visibility of discount price field when checkbox is changed
        isDiscountCheckbox.addEventListener('change', function() {
            if (this.checked) {
                discountPriceWrapper.style.display = 'block';
            } else {
                discountPriceWrapper.style.display = 'none';
                discountPriceField.value = ''; // Clear discount price if unchecked
            }
        });

        // Automatically check is_discount checkbox when a discount price is entered
        discountPriceField.addEventListener('input', function() {
            if (this.value > 0) {
                isDiscountCheckbox.checked = true;
                discountPriceWrapper.style.display = 'block';
            }
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        // Fungsi untuk upload gambar secara otomatis saat dipilih
        $('#images').on('change', function() {
            var formData = new FormData();
            var files = $('#images')[0].files;
            for (var i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('product.uploadImages', $product->id) }}", // Route untuk upload gambar
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Tampilkan gambar yang baru diunggah
                    response.images.forEach(function(image) {
                        var newImage = `
                            <div class="col-md-3 mb-3" id="image-${image.id}">
                                <img src="${image.url}" alt="Product Image" class="img-fluid">
                                <button type="button" class="btn btn-sm btn-danger mt-2 delete-image" data-id="${image.id}">
                                    Delete Image
                                </button>
                            </div>`;
                        $('.row.mb-3 .row').append(newImage);
                    });
                    $('#images').val('');

                },
                error: function(response) {
                    console.log('Failed to upload image.');
                }
            });
        });

        // Hapus gambar dengan AJAX (sama seperti sebelumnya)
        $(document).on('click', '.delete-image', function() {
            var imageId = $(this).data('id');
            var url = "{{ url('admin/product/image') }}/" + imageId;

            if (confirm('Are you sure you want to delete this image?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $('#image-' + imageId).remove();
                    },
                    error: function(response) {
                        console.log('Failed to delete image.');
                    }
                });
            }
        });

        // Hapus video dengan AJAX (sama seperti sebelumnya)
        $(document).on('click', '.delete-video', function() {
            var videoId = $(this).data('id');
            var url = "{{ url('admin/product/video') }}/" + videoId;

            if (confirm('Are you sure you want to delete this video?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $('#video-' + videoId).remove();
                    },
                    error: function(response) {
                        console.log('Failed to delete video.');
                    }
                });
            }
        });
    });
</script>


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
    

@endsection
