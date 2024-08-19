<table class="table table-hover w-auto text-nowrap" id="myTable" >
        <thead class="bg-primary text-white">
            <tr>
                <th scope="col" data-field="ID" data-sortable="true">
                    <div class="th-inner">ID</div>
                </th>
                <th scope="col" data-field="Nombre" data-sortable="true">
                    <div class="th-inner">Nombre</div>
                </th>
                <th scope="col" data-field="Email" data-sortable="true">
                    <div class="th-inner">Email</div>
                </th>
                <th scope="col" data-field="area_I" data-sortable="true">
                    <div class="th-inner">Área I</div>
                </th>
                <th scope="col" data-field="area_II" data-sortable="true">
                    <div class="th-inner">Área II</div>
                </th>
                <th scope="col" data-field="area_III" data-sortable="true">
                    <div class="th-inner">Área III</div>
                </th>
                <th scope="col" data-field="Presidencia 1" data-sortable="true">
                    <div class="th-inner">Presidencia 1</div>
                </th>
                <th scope="col" data-field="Presidencia 2" data-sortable="true">
                    <div class="th-inner">Presidencia 2</div>
                </th>
                <th scope="col" data-field="habilitado" data-sortable="true">
                    <div class="th-inner">Habilitado</div>
                </th>
                @if($downloadExcel == TRUE)
			    @elseif ($downloadExcel == FALSE)
                <th scope="col" data-field="Acciones">
                    <div class="th-inner">Acciones</div>
                </th>
                @endif
            </tr>    
        </thead>

        <tbody>
            @foreach($profesors as $profesor)
            <tr>
                <td>{{$profesor->idProfesor}}</td>
                <td>{{$profesor->user->getCompleteNameAttribute()}}</td>
                <td>{{$profesor->user->email}}</td>
                <td>{{$profesor->area_I}}</td>
                <td>{{$profesor->area_II}}</td>
                <td>{{$profesor->area_III}}</td>
                <td>{{$profesor->presidente1}}</td>
                <td>{{$profesor->presidente2}}</td>
                <td>@if($profesor->habilitado == 1) Habilitado @else Inhabilitado @endif</td>
                @if($downloadExcel == TRUE)
			    @elseif ($downloadExcel == FALSE)
                <td>
                    <button type="button" class="btn btn-warning mr-1" data-toggle="modal" data-target="#editProfesor{{$profesor->idProfesor}}">Editar</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminarProfesor{{$profesor->idProfesor}}">Eliminar</button>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
        <script>
            $(document).ready( function () {
                $('#myTable').DataTable({
                });
            } );
        </script>
    </table>