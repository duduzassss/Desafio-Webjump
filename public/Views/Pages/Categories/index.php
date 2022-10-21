  <!-- Main Content -->
  <main class="content" style="margin-bottom: 3rem;">
    <div class="header-list-page">
      <h1 class="title">Categories</h1>
      <a href="{{URL}}/categories/create" class="btn-action">Add new Category</a>
    </div>
    <table class="data-grid">
      <tr class="data-row">
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Name</span>
        </th>

        <th class="data-grid-th">
            <span class="data-grid-cell-content">Code</span>
        </th>
        
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Actions</span>
        </th>
      </tr>
      
      {{itens}}
     
    </table>
  </main>
  <!-- Main Content -->