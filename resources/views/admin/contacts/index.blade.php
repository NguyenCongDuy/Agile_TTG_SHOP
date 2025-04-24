@extends('layout.AdminLayout')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách liên hệ</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người gửi</th>
                            <th>Nội dung</th>
                            <th>Ngày gửi</th>
                            <th>Trạng thái</th>
                            <th>Người xử lý</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ Str::limit($contact->noi_dung, 100) }}</td>
                            <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($contact->is_processed)
                                    <span class="badge bg-success">Đã xử lý</span>
                                @else
                                    <span class="badge bg-warning">Chưa xử lý</span>
                                @endif
                            </td>
                            <td>
                                @if($contact->processedBy)
                                    {{ $contact->processedBy->name }}
                                    <br>
                                    <small class="text-muted">{{ $contact->processed_at->format('d/m/Y H:i') }}</small>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(!$contact->is_processed)
                                    <form action="{{ route('admin.contacts.process', $contact->id) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-success btn-sm"
                                                onclick="return confirm('Bạn có chắc chắn muốn xác nhận đã xử lý?')">
                                            <i class="bi bi-check-lg"></i> Xác nhận
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" 
                                      method="POST" 
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa liên hệ này?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
