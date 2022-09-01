@extends('layouts.app', ['activePage' => 'shippings', 'titlePage' => __('Shippings')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                   <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title pull-left">My Shippings</h4>
                            <button onclick="importShipping()" class="btn btn-default pull-right" id="btnImport" style="border:solid 1px; border-radius:20px;">
                                <i class="fa fa-refresh fa-spin" id="loadingIcon"></i>
                                Import CSV
                            </button>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th>#</th>
                                    <th>Do Cep</th>
                                    <th>Ao Cep</th>
                                    <th>Do Peso</th>
                                    <th>Ao Peso</th>
                                    <th>Preço</th>
                                </thead>
                                <tbody>
                                    @forelse($shippings as $shipping)
                                        <tr>
                                            <td>{{ $shipping->id }}</td>
                                            <td class="cep">{{ $shipping->from_postcode }}</td>
                                            <td class="cep">{{ $shipping->to_postcode }}</td>
                                            <td>{{ $shipping->from_weight }}</td>
                                            <td>{{ $shipping->to_weight }}</td>
                                            <td>R$ {{ number_format($shipping->cost, 2, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" align="center">Nenhum dado importado</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                            @if (!empty($shippings))
                                <ul class="pagination" style="align-content: center; justify-content: center;">
                                    {{ $shippings->links() }}
                                </ul>
                            @endif
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        var btnImport = document.getElementById('btnImport');
        var loadingIcon = document.getElementById('loadingIcon');
        window.onload = function() {
            $(loadingIcon).css('display', 'none');
            $('.cep').mask('00000-000');
        }
        async function importShipping() {
            const { value: file } = await Swal.fire({
                title: 'Selecione o Arquivo',
                input: 'file',
                inputAttributes: {
                    'accept': '*',
                    'aria-label': 'Selecione seu arquivo'
                },
            })
            if (file) {
                await importFile(file);
            }
        }

        function importFile(file) {
            var formData = new FormData();
            formData.append('shipping_file', file);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            $.ajax({
                beforeSend: function() {
                    $(loadingIcon).toggle();
                    btnImport.setAttribute('disabled', 'disabled')
                },
                url: '/shippings/import',
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    displayResult(data.message, 'success');
                },
                error: function(err) {
                    displayResult(err.message, 'error')
                },
                complete: function() {
                    $(loadingIcon).toggle();
                    btnImport.removeAttribute('disabled');
                }
            })
        }

        function displayResult(message, type) {
            Swal.fire({
                title: type == 'error' ? 'Opss...Ocorreu um erro' : 'Sucesso! :)',
                text: `${message}`,
                icon: `${type}`,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }) .then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/shippings'
                }
            })
        }
    </script>
@endpush
