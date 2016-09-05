<section class="content">
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">{title_form}</h3>
        <div class="pull-right">
          <button type="button" class="btn btn-primary" onclick="document.location.href='<?php echo base_url()?>inventory/permohonanbarang/add'"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah</button>
          <button type="button" class="btn btn-warning" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
          <button type="button" class="btn btn-success" id="btn-export"><i class='fa fa-file-excel-o'></i> &nbsp; Export</button>  
        </div>
      </div>
      <div class="box-footer">
        <div style="float: left;" id="jqxlistbox1"></div>
        <div style="float: left;" id="jqxlistbox2"></div>
      </div>
      <div class="box-body">
        <div id='jqxWidget'>
            <div style="margin-left: 20px; float: left;" id="treeGrid"></div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        var data = [
           {
               "id": "1", "name": "Corporate Headquarters", "budget": "1230000", "location": "Las Vegas",
               "children":
                [
                    {
                        "id": "2", "name": "Finance Division", "budget": "423000", "location": "San Antonio",
                        "children":
                        [
                            { "id": "3", "name": "Accounting Department", "budget": "113000", "location": "San Antonio" },
                            {
                                "id": "4", "name": "Investment Department", "budget": "310000", "location": "San Antonio",
                                children:
                                [
                                    { "id": "5", "name": "Banking Office", "budget": "240000", "location": "San Antonio" },
                                    { "id": "6", "name": "Bonds Office", "budget": "70000", "location": "San Antonio" },
                                ]
                            }
                        ]
                    },
                    {
                        "id": "7", "name": "Operations Division", "budget": "600000", "location": "Miami",
                        "children":
                        [
                            { "id": "8", "name": "Manufacturing Department", "budget": "300000", "location": "Miami" },
                            { "id": "9", "name": "Public Relations Department", "budget": "200000", "location": "Miami" },
                            { "id": "10", "name": "Sales Department", "budget": "100000", "location": "Miami" }
                        ]
                    },
                    { "id": "11", "name": "Research Division", "budget": "200000", "location": "Boston" }
                ]
           }
        ];
        var source =
         {
             dataType: "json",
             dataFields: [
                  { name: "name", type: "string" },
                  { name: "budget", type: "number" },
                  { name: "id", type: "number" },
                  { name: "children", type: "array" },
                  { name: "location", type: "string" }
             ],
             hierarchy:
                 {
                     root: "children"
                 },
             localData: data,
             id: "id"
         };
        var dataAdapter = new $.jqx.dataAdapter(source, {
            loadComplete: function () {
            }
        });
        // create jqxTreeGrid.
        $("#treeGrid").jqxTreeGrid(
        {
            source: dataAdapter,
            altRows: true,
            showHeader: true,
            ready: function () {
                $("#treeGrid").jqxTreeGrid('expandRow', '1');
                $("#treeGrid").jqxTreeGrid('expandRow', '2');
            },
            columns: [
              { text: "Name",  align: "center", dataField: "name", width: 240 },
              { text: "Budget", cellsAlign: "center", align: "center",columnGroup: "JSTCorp", dataField: "budget",hidden: true, cellsFormat: "c2", width: 200 },
              { text: "Location", dataField: "location", columnGroup: "JSTCorp",cellsAlign: "center", align: "center", hidden: true, width: 200 }
            ],
            columnGroups:
            [
              { text: "JST Corp.", name: "JSTCorp", align: "center" }
            ]
        });
        var listSource1 = [{ label: 'Budget', value: 'budget', checked: true }];
        var listSource2 = [{ label: 'Location', value: 'location', checked: false }];
        $("#jqxlistbox1").jqxListBox({ source: listSource1, width: '50%', height: 100,  checkboxes: true });
        $("#jqxlistbox2").jqxListBox({ source: listSource2, width: '50%', height: 100,  checkboxes: true });
        $("#jqxlistbox2").on('checkChange', function (event) {
            $("#treeGrid").jqxTreeGrid('beginUpdate');
            columns1 = event.args.value;
            columns2 = 'budget';
            if (event.args.checked) {
                $("#treeGrid").jqxTreeGrid('showColumn', columns2);
                $("#treeGrid").jqxTreeGrid('showColumn', columns1);
            }
            else {
                $("#treeGrid").jqxTreeGrid('hideColumn', event.args.value);
            }
            $("#treeGrid").jqxTreeGrid('endUpdate');
        });
    });
</script>