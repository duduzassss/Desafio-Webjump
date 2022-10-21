
  <!-- Main Content -->
  <main class="content">
    <h1 class="title new-item">Delete Category</h1>
    
    <form method="POST">
      <div class="actions-form">
        <a href="{{URL}}/categories" class="action back">Back</a>
        <span style="font-weight: bold; color: red;">Você deseja realmente excluir o produto [{{name}}] ?</span>
        <input class="btn-submit btn-action" type="submit" value="Delete Category" />
      </div>

      <div class="input-field">
        <label for="name" class="label">Category Name</label>
        <input type="text" id="name" name="name" value="{{name}}" class="input-text" disabled/> 
      </div>
      <div class="input-field">
        <label for="code" class="label">Category Code</label>
        <input type="text" id="code" name="code" value="{{code}}" class="input-text" disabled/> 
      </div>
           
    </form>
  </main>
  <!-- Main Content -->