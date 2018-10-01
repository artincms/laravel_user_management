<script>
    window['logs_grid_columns'] = [
        {
            width: '5%',
            data: 'id',
            title: 'ردیف',
            searchable: false,
            sortable: false,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            width: '5%',
            data: 'id',
            name: 'id',
            title: 'آی دی',
            visible:false
        },
        {
            width: '5%',
            data: 'ip',
            name: 'ip',
            title: 'آی پی',
        },
        {
            width: '10%',
            data: 'username',
            name: 'username',
            title: 'نام کاربری',
        },
        {
            width: '10%',
            data: 'created_at',
            name: 'created_at',
            title: 'تاریخ ورود',
        },
    ];
    $(document).off("click", ".login_history_tab");
    $(document).on("click", ".login_history_tab", function () {
        var getUsersRoute = '{{ route('LUM.Roles.getLogs') }}';
        var fixedColumn = {
            leftColumns: 3,
            rightColumns: 1
        };
        dataTablesGrid('#LogsGridData', 'LogsGridData', getUsersRoute, logs_grid_columns, null, null, true, null, null, 1, 'desc', false, fixedColumn);
    });
</script>