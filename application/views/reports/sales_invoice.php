<tr>
                <td class="active"></td>
                <td colspan="22">
                  <table id="invoice" class="table table-striped dt-right" style="width:100%;">
                    <thead>
                      <tr class="tablehead text3D">
                        <th>Invoice ID</th>
                        <th>Customer</th>
                        <th>Terminal</th>
                        <th>Payment Method</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Total Tax</th>
                        <th>Service Charge</th>
                        <th>Tip</th>
                        <th>Rounding</th>
                        <th>Paid Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                      foreach($this->sales->get_order_invoice($row->OID) as $rowi){
                    ?>
                      <tr>
                        <td><?=$rowi->IID?></td>
                        <td><?=$rowi->CUSTOMER_NAME?></td>
                        <td><?=$rowi->TERMINAL_NAME?></td>
                        <td><?=$rowi->PAYMENT_METHOD?></td>
                        <td><?=$rowi->TOTAL?></td>
                        <td><?=$rowi->DISCOUNT?></td>
                        <td><?=$rowi->TOTAL_TAX?></td>
                        <td><?=$rowi->SERVICE_CHARGE?></td>
                        <td><?=$rowi->TIP?></td>
                        <td><?=$rowi->ROUNDING?></td>
                        <td><?=$rowi->PAID_AMOUNT?></td>
                      </tr>
                      <tr>
                        <td class="active"></td>
                        <td colspan="10">
                          <table id="odetail" class="table table-striped dt-right" style="width:100%;">
                            <thead>
                              <tr class="tablehead text3D">
                                <th>Menu Name</th>
                                <th>Category Name</th>
                                <th>Kitchen Note</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody> 
                            <?php 
                              foreach($this->sales->get_order_details($rowi->IID) as $rowd){
                            ?>
                              <tr>
                                <td><?=$rowd->MENU_NAME?></td>
                                <td><?=$rowd->CATEGORY_NAME?></td>
                                <td><?=($rowd->KITCHEN_NOTE==NULL)?"-":$rowd->KITCHEN_NOTE?></td>
                                <td><?=$rowd->QUANTITY?></td>
                                <td><?=$rowd->PRICE?></td>
                                <td><?=$rowd->TOTAL?></td>
                              </tr>
                            <?php } ?>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </td>
						  </tr>