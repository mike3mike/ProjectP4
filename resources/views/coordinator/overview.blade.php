@extends('layouts.app')
@section('content')

<body>
    <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">opdrachten</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 20%">
                          naam
                      </th>
                      <th style="width: 30%">
                          adress
                      </th>
                      <th style="width: 10%">
                          aantal leden
                      </th>
                      <th>
                          datum en tijd
                      </th>
                      <th style="width: 8%" class="text-center">
                          Status
                      </th>
                      <th style="width: 30%">
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>
                          opdrachtnaam
                      </td>
                      <td>
                          <a>
                              lovendijksstraat 61
                          </a>
                          <br/>
                          <small>
                            5945 GT Breda
                          </small>
                      </td>
                      <td>
                <a>4/4</a>
                          </ul>
                      </td>
                      <td>
                         17/05/2023
                      <td class="project-state">
                          <span class="badge badge-success">Success</span>
                      </td>
                      <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="#">
                              <i class="fas fa-folder">
                              </i>
                              bekijk
                          </a>
                          <a class="btn btn-info btn-sm" href="#">
                              <i class="fas fa-pencil-alt">
                              </i>
                              bewerk
                          </a>
                          <a class="btn btn-danger btn-sm" href="#">
                              <i class="fas fa-trash">
                              </i>
                              verwijder
                          </a>
                      </td>
                  </tr>
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    
</body>
@endsection
