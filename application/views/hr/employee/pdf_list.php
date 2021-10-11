<? if($letterslist){ ?>
<h4>PDF List </h4>

<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
        <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
          <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
          <table class="table">
            <thead>
            <tr>
              <th>Leter Type</th>
              <th>Date</th>
              <th>Pdf</th>
            </tr>
            </thead>
            <tbody>
            <?php
              $c = 0;
              foreach($letterslist as $raw){ ?>
              <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <td><?=$raw->Name ?></td>
                <td><?=$raw->date  ?></td>
                <td><a href="<?= base_url().$raw->file?>" title="Download" target="_blank"><i class="fa fa-print nav_icon icon_blue"></i></a></td>
                <td>
                </td>
                <td align="right">
                <div id="checherflag">
                  
                </div>
                </td>
              </tr>
              <?php
              }
            } ?>
            </tbody>
          </table>
          </div>
        </div>
        </div>