
  <!-- Main Content -->
  <main class="content">
    <h1 class="title new-item">Edit Product</h1>

    <div style="display:flex; justify-content:center;">
      <img src="{{image}}" style="max-width: 356px; height: 100px;"/>
    </div>
    
    <form method="POST" enctype="multipart/form-data">
      <div class="input-field">
        <label for="sku" class="label">Product SKU</label>
        <input type="text" id="sku" name="sku" value="{{sku}}" class="input-text" required/> 
      </div>
      <div class="input-field">
        <label for="name" class="label">Product Name</label>
        <input type="text" id="name" name="name" value="{{name}}" class="input-text" required/> 
      </div>
      <div class="input-field">
        <label for="price" class="label">Price</label>
        <input type="text" id="price" name="price" value="{{price}}" class="input-text" onkeyup="formatCurrency()" required/> 
      </div>
      <div class="input-field">
        <label for="quantity" class="label">Quantity</label>
        <input type="text" id="quantity" name="quantity" value="{{quantity}}" class="input-text" required/> 
      </div>
      <div class="input-field">
        <label for="categories" class="label">Categories</label>
        <select multiple id="categories" name="categories[]" class="input-text" required>
          {{select_categories}}
        </select>
      </div>
      <div class="input-field">
        <label for="description" class="label">Description</label>
        <textarea id="description" name="description" class="input-text" required>{{description}}</textarea>
      </div>

      <div class="input-field">
        <label for="image" class="label">Image</label>
        <input type="file" name="image" id="image" class="input-text">
      </div>

      <div class="actions-form">
        <a href="{{URL}}/products" class="action back">Back</a>
        <input class="btn-submit btn-action" type="submit" value="Save Product" />
      </div>
      
    </form>
  </main>
  <!-- Main Content -->