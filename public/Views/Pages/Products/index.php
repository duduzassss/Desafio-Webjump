  <!-- Main Content -->
  <main class="content" style="margin-bottom: 3rem;">
    <div class="header-list-page">
      <h1 class="title">Products</h1>
      <a href="{{URL}}/products/create" class="btn-action">Add new Product</a>
    </div>


    <table class="data-grid">
      <tr class="data-row">
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Name</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">SKU</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Price</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Quantity</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Categories</span>
        </th>

        <th class="data-grid-th">
            <span class="data-grid-cell-content">Actions</span>
        </th>
      </tr>
      
      {{itens}}
     
    </table>
  </main>
  <!-- Main Content -->