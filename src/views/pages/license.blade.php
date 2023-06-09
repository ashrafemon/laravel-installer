@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="licence" x-data="licenses">
        <form @submit.prevent="submitHandler">
            <div class="my-3">
                <label class="form-label">Select Product</label>
                <select class="form-select" x-model="form.product_id" @chanage="errors.product_id.show = false" disabled>
                    <option value="" disabled>Select Product</option>
                    <template x-for="(item,i) in products?.data" :key="i">
                        <option :selected="item?.unique_id == form.product_id ? 'selected' : ''" :value="item?.unique_id"
                            x-text="item?.name">
                        </option>
                    </template>
                </select>

                <template x-if="errors.product_id.show">
                    <p x-text="errors.product_id.text" class="text-danger"></p>
                </template>
            </div>
            <div>
                <label class="form-label">Licence Code</label>
                <input type="text" class="form-control" x-model="form.code" @keyup="errors.code.show = false">

                <template x-if="errors.code.show">
                    <p x-text="errors.code.text" class="text-danger"></p>
                </template>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-outline-primary" :disabled="loading"
                    x-text="loading ? 'Loading...': 'Check License'">Check License</button>
            </div>
        </form>
    </div>
@endsection

@push('custom-js')
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("licenses", () => ({
                form: {
                    product_id: '',
                    code: ''
                },
                errors: {
                    product_id: {
                        text: '',
                        show: false
                    },
                    code: {
                        text: '',
                        show: false
                    },
                },
                loading: false,
                selectedProductId: null,
                products: {},
                async init() {
                    await fetch('/api/v1/products', {
                            method: "GET",
                            headers: {
                                Accept: 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.status === 'success') {
                                this.products = res?.data?.products || [];
                                this.form.product_id = res?.data?.selected_product_id;
                            }
                        })
                        .catch(err => console.log(err))
                },
                async submitHandler() {
                    this.loading = true;
                    await fetch('/api/v1/licenses/validate', {
                            method: "POST",
                            headers: {
                                Accept: 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.status === 'validate_error') {
                                Object.keys(res.data).forEach((key) => {
                                    if (res.data[key]) {
                                        this.errors[key] = {
                                            text: res.data[key],
                                            show: true
                                        }
                                    }
                                })
                            } else {
                                Swal.fire({
                                    title: res.message,
                                    icon: res.status === 'success' ? 'success' :
                                        'error',
                                    timer: 2500
                                })

                                if (res.status === 'success') {
                                    setTimeout(() => {
                                        window.location.href = '/installer/database'
                                    }, 1000);
                                }
                            }
                        })
                        .catch(err => console.log(err))
                    this.loading = false;
                }


            }))
        })
    </script>
@endpush
