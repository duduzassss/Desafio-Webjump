
  <!-- Main Content -->
  <main class="content">
    <h1 class="title new-item">Delete Product</h1>
    
    <form method="POST">
      <div class="actions-form">
        <a href="{{URL}}/products" class="action back">Back</a>
        <span style="font-weight: bold; color: red;">Você deseja realmente excluir o produto [{{name}}] ?</span>
        <input class="btn-submit btn-action" type="submit" value="Delete Product" />
      </div>

      <div class="input-field">
        <label for="sku" class="label">Product SKU</label>
        <input type="text" id="sku" name="sku" value="{{sku}}" class="input-text" disabled/> 
      </div>
      <div class="input-field">
        <label for="name" class="label">Product Name</label>
        <input type="text" id="name" name="name" value="{{name}}" class="input-text" disabled/> 
      </div>
      
    </form>
  </main>
  <!-- Main Content -->