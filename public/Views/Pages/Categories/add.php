
  <!-- Main Content -->
  <main class="content">
    <h1 class="title new-item">New Category</h1>
    
    <form method="POST">
      <div class="input-field">
        <label for="name" class="label">Category Name</label>
        <input type="text" id="name" name="name" class="input-text" required/> 
      </div>
      <div class="input-field">
        <label for="code" class="label">Category Code</label>
        <input type="text" id="code" name="code" class="input-text" required/> 
      </div>
     

      <div class="actions-form">
        <a href="{{URL}}/categories" class="action back">Back</a>
        <input class="btn-submit btn-action" type="submit" value="Save Category" />
      </div>
      
    </form>
  </main>
  <!-- Main Content -->