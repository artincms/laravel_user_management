<script type="text/javascript">
    window['roles_grid_columns'] = [
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
            width: '10%',
            data: 'name',
            name: 'name',
            title: 'نام',
        },
        {
            width: '10%',
            data: 'display_name',
            name: 'display_name',
            title: 'نام نمایشی',
        },
        {
            width: '10%',
            data: 'description',
            name: 'description',
            title: 'توضیحات',
        },
        {
            width: '10%',
            data: 'created_at',
            name: 'created_at',
            title: 'تاریخ ایجاد',
        },
        {
            width: '10%',
            searchable: false,
            sortable: false,
            title: 'عملیات',
            mRender: function (data, type, full) {
                return '' +
                    '<div class="gallerty_menu float-right" onclick="set_fixed_dropdown_menu(this)" data-toggle="dropdowns">' +
                    '<span>' +
                    '   <em class="fas fa-caret-down"></em>' +
                    '   <i class="fas fa-bars"></i> ' +
                    '</span>' +
                    '  <div class="dropdown_gallery hidden">' +
                    '   <a class="btn_edit_roles pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                    '   </a>' +
                    '    <a class="btn_trash_roles pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + ' ">' +
                    '       <i class="fa fa-trash"></i><span class="ml-2">حذف</span>' +
                    '   </a>'
                    '  </div>' +
                    '</div>';
            }
        }
    ];
    $(document).ready(function () {
        var getRolesRoute = '{{ route('LUM.Roles.getRoles') }}';
        dataTablesGrid('#RolesGridData', 'RolesGridData', getRolesRoute, roles_grid_columns);
    });
</script>