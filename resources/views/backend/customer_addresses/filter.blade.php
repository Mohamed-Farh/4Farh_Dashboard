<div class="card-body">
    <form action="{{ route('admin.customer_addresses.index') }}" method="get">
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <input type="text" name="keyword" value="{{ old('keyword', request()->input('keyword')) }}" class="form-control" placeholder="Search Here">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="status" class="form-control">
                        <option value="">Status</option>
                        <option value="1" {{ old('status', request()->input('status')) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', request()->input('status')) == '0' ? 'selected' : ''  }}>InActive</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="sort_by" class="form-control">
                        <option value="">Sort By</option>
                        <option value="id" {{ old('sort_by', request()->input('sort_by')) == 'id' ? 'selected' : '' }}>ID</option>
                        <option value="name" {{ old('sort_by', request()->input('nasort_byme')) == 'name' ? 'selected' : ''  }}>Name</option>
                        <option value="created_at" {{ old('sort_by', request()->input('sort_by')) == 'created_at' ? 'selected' : ''  }}>Date</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="order_by" class="form-control">
                        <option value="">Order By</option>
                        <option value="asc" {{ old('order_by', request()->input('order_by')) == 'asc' ? 'selected' : '' }}>ASC</option>
                        <option value="desc" {{ old('order_by', request()->input('order_by')) == 'desc' ? 'selected' : ''  }}>DESC</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="limit_by" class="form-control">
                        <option value="">Limit By</option>
                        <option value="10" {{ old('limit_by', request()->input('limit_by')) == '10' ? 'selected' : '' }}>10</option>
                        <option value="20" {{ old('limit_by', request()->input('limit_by')) == '20' ? 'selected' : ''  }}>20</option>
                        <option value="50" {{ old('limit_by', request()->input('limit_by')) == '50' ? 'selected' : ''  }}>50</option>
                        <option value="100" {{ old('limit_by', request()->input('limit_by')) == '100' ? 'selected' : ''  }}>100</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-link">Search</button>
                </div>
            </div>
        </div>
    </form>
</div>
