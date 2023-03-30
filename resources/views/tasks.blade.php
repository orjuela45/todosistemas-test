<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tasks</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  
</head>
<body>
  <script>
  </script>
  <div class="container-fluid m-4">
    <div class="row justify-content-evenly">
      <div class="col-3 col-xs-12 text-center rounded border ">
        <h1 class="p-2 mt-3">Create new task</h1>
        <form class="text-start px-5 my-4">
          <div class="mb-3">
            <input type="text" class="form-control" id="idInput" disabled hidden>
          </div>
          <div class="mb-3">
            <label for="titleInput" class="form-label">Title</label>
            <input type="text" class="form-control" id="titleInput">
          </div>
          <div class="mb-3">
            <label for="descriptionInput" class="form-label">Description</label>
            <textarea class="form-control" id="descriptionInput" cols="30" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="descriptionInput" class="form-label">Employe</label>
            <select class="form-select" id="employeSearchBox">
              <option selected>Select Employe</option>
              @foreach ($employes as $employe)
                <option id={{"option-".$employe->id}} value={{$employe->id}} class={{$employe->status == 'ACTIVE' ? '' : 'text-danger'}} >{{$employe->fullname}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="executionDateInput" class="form-label">Execution date</label>
            <input type="datetime-local" class="form-control" id="executionDateInput" min="now">
          </div>
          <button type="submit" class="btn btn-primary" id="btnSubmit">Submit</button>
          <button type="submit" class="btn btn-success" hidden id="btnUpdate">Update</button>
        </form>
      </div>
      <div class="col-7 col-xs-12 text-center rounded border ">
        <h1 class="p-2 mt-3">List of tasks</h1>
        <table class="table" id="taskTable">
          <thead class="thead">
            <tr>
              <th scope="col">id</th>
              <th scope="col">title</th>
              <th scope="col">Employe</th>
              <th scope="col">Execution Date</th>
              <th scope="col">Delay days</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script>
    const titleInput = document.getElementById("titleInput")
    const descriptionInput = document.getElementById("descriptionInput")
    const employeSearchBox = document.getElementById("employeSearchBox")
    const executionDateInput = document.getElementById("executionDateInput")
    const idInput = document.getElementById("idInput")
    const btnSubmit = document.getElementById("btnSubmit")
    const btnUpdate = document.getElementById("btnUpdate")
    
    let tasks = {{ Js::from($tasks) }};
    let taskTable = null;
    
    $(document).ready( function () {

      taskTable =  $('#taskTable').DataTable({
        data:tasks,
        columns: [
          { data: 'id', name: "id"},
          { data: 'title', name: "title"},
          { data: 'employe.fullname', name: "employe"},
          { data: 'execution_date', name: "execution_day"},
          { data: 'delay', name: "delay"},
          {
            data: null,
            render: function(data, type, full, meta){
                return '<button class="btn btn-primary btn-sm m-1" onclick="editTask('+data.id+')">Edit</button>' +
                  '<button class="btn btn-danger btn-sm m-1" onclick="deleteTask('+data.id+')">Delete</button>';
            },
            "orderable": false,
            "searchable": false
          }
        ]
      });
    });


    function getRowIndexFromTableWithIndex(id){
      let rowIndex = taskTable.rows().eq(0).filter(function(index){
        return taskTable.cell(index, 0).data() === id;
      });
      return rowIndex
    }

    function editTask(id){
      
      const rowIndex = getRowIndexFromTableWithIndex(id)
      const rowData = taskTable.row(rowIndex).data();

      idInput.value = id
      titleInput.value = rowData.title 
      descriptionInput.value = rowData.description
      executionDateInput.value = rowData.execution_date
      
      const optionToSelect = document.getElementById("option-"+rowData.employe_id)
      optionToSelect.selected = true;

      btnSubmit.hidden = true
      btnUpdate.hidden = false
    }
    
    function deleteTask(id){
      const rowIndex = getRowIndexFromTableWithIndex(id)
      axios.delete("/api/task/"+id).then(function (response) {
        Toastify({
          text: "Task Deleted",
          style: {
            background: "green",
          },
        }).showToast();
        taskTable.row(rowIndex).remove().draw();
      })
    }

    btnSubmit.addEventListener("click", function(event){
      event.preventDefault()
      axios.post("/api/task",{
        title: titleInput.value,
        description: descriptionInput.value,
        employe_id: employeSearchBox.value,
        execution_date: executionDateInput.value,
      }).then(function (response) {
        Toastify({
          text: "Task created",
          style: {
            background: "green",
          },
        }).showToast();
        taskTable.row.add(response.data).draw()
      })
      .catch(function (error) {
        const {errors, message} = error.response.data
        for (const value in errors) {
          Toastify({
            text: errors[value][0],
            style: {
              background: "red",
            },
          }).showToast();
        }
      });
    });
    
    btnUpdate.addEventListener("click", function(event){
      event.preventDefault()
      axios.put("/api/task/"+idInput.value ,{
        title: titleInput.value,
        description: descriptionInput.value,
        employe_id: employeSearchBox.value,
        execution_date: executionDateInput.value,
      }).then(function (response) {
        const rowIndex = getRowIndexFromTableWithIndex(+idInput.value)
        taskTable.row(rowIndex).data(response.data).draw();
        Toastify({
            text: "Task update",
            style: {
              background: "green",
            },
          }).showToast();
      })
      .catch(function (error) {
        if (error.response.data.errors){
          for (const value in error.response.data.errors) {
            Toastify({
              text: errors[value][0],
              style: {
                background: "red",
              },
            }).showToast();
          }
          return
        }
        Toastify({
          text: error.response.data,
          style: {
            background: "red",
          },
        }).showToast();
      });
    });
  </script>
</body>
</html>