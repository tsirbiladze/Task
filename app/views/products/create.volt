<div class="row">
    <div class="col-12">
        {{ flash.output() }}
        {{ flashSession.output() }}
        <div class="card">
            <div class="card-header">
                <h4>Create a Product</h4>
            </div>
            <div class="card-body">
                {{ form() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    {{ form.render("name", ["class": "form-control"]) }}
                </div>
                <div class="form-group">
                    <label for="price">Price (in $)</label>
                    {{ form.render("price", ["class": "form-control", "placeholder": "Enter price in $", "step": "0.01"]) }}
                </div>
                <div class="form-group">
                    <label for="weight">Weight (in kg)</label>
                    {{ form.render("weight", ["class": "form-control", "placeholder": "Enter weight in kg", "step": "0.01"]) }}
                </div>
                
                <div class="btn-group">
                    {{ submit_button("Save", "class": "btn btn-success", 'value':'Save') }}
                    {{ link_to("/products", 'Cancel', "class": "btn btn-warning") }}
                </div>
                {{ form.render('csrf', ['value': security.getToken()]) }}
                {{ end_form() }}
            </div>
        </div>
    </div>
</div>
