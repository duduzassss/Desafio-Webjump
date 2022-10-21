
      <tr class="data-row">
        <td class="data-grid-td">
           <span class="data-grid-cell-content">{{name}}</span>
        </td>
      
        <td class="data-grid-td">
           <span class="data-grid-cell-content">{{sku}}</span>
        </td>

        <td class="data-grid-td">
           <span class="data-grid-cell-content">{{price}}</span>
        </td>

        <td class="data-grid-td">
           <span class="data-grid-cell-content">{{quantity}}</span>
        </td>

        <td class="data-grid-td">
         {{categories}}
        </td>

        <td class="data-grid-td">
          <div class="actions" style="display:flex; justify-content:center;">
            <div class="action edit" style="margin-right: 1rem;">
                <a href="{{URL}}/products/{{id}}/edit">
                  <i class="fa-solid fa-pencil"></i>
                </a>
            </div>
            <div class="action delete">
                <a href="{{URL}}/products/{{id}}/delete">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </div>
          </div>
        </td>
      </tr>
     