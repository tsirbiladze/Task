<div class="row">
    <div class="col-12">
        {{ flash.output() }}
        {{ flashSession.output() }}
        <div class="card">
            <div class="card-header">
                {{ link_to("products/create", "Create a Product", "class": "btn btn-primary btn-sm") }}
            </div>

            <div class="card-body">
                <table class="table table-hover responsive" id="dataTables" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Weight</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for product in products %}
                        <tr>
                            <td>{{ product.id }}</td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.weight }} kg</td>
                            <td>${{ product.price }}</td>
                            <td>{{ product.created_at }}</td>
                            <td>{{ product.updated_at }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="">
                                    {{ link_to("/products/edit/" ~ product.id, '<i class="fas fa-edit"></i>', "class": "btn btn-primary btn-sm") }}
                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete"
                                       onclick="deleteProduct({{ product.id }})"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
                
            </div>
            <div class="card-footer small text-muted">Updated {{ date("Y-m-d H:i:s") }}</div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal-delete"></div>
        </div>
    </div>
</div>

