<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name', 'Grading Management') }}</title>
        
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <h1>Grading Management</h1>

        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @elseif(session('failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('failed') }}
        </div>
        @endif

        <div class="container">
          <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <h3>Grafik</h3>
                <div class="card chart-container" style="position: relative; height:40vh; width:40vw">
                    <canvas id="grading-chart"></canvas>
                </div>
            </div>
            <div class="col-md-auto">
                <h3>Form Nilai Mahasiswa</h3>
                <form action="/insert" method="post">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                  <div class="form-group">
                    <label>Nama Mahasiswa</label>
                    <input type="text" name="name" class="form-control" placeholder="Input Nama">
                  </div>
                  <div class="row justify-content-md-center">
                      <div class="col-md-auto">
                          <div class="form-group">
                            <label>Nilai Quiz</label>
                            <input type="integer" name="quiz_score" class="form-control" aria-describedby="quizHelp" placeholder="Input nilai quiz">
                            <small id="quizHelp" class="form-text text-muted">Range nilai 0-100</small>
                          </div>
                      </div>
                      <div class="col-md-auto">
                          <div class="form-group">
                            <label>Nilai Tugas</label>
                            <input type="integer" name="task_score" class="form-control" aria-describedby="taskHelp" placeholder="Input nilai tugas">
                            <small id="taskHelp" class="form-text text-muted">Range nilai 0-100</small>
                          </div>
                      </div>
                  </div>
                  <div class="row justify-content-md-center">
                      <div class="col-md-auto">
                          <div class="form-group">
                            <label>Nilai Absensi</label>
                            <input type="integer" name="presence_score" class="form-control" aria-describedby="presenceHelp" placeholder="Input nilai absensi">
                            <small id="presenceHelp" class="form-text text-muted">Range nilai 0-100</small>
                          </div>
                      </div>
                      <div class="col-md-auto">
                          <div class="form-group">
                            <label>Nilai Praktek</label>
                            <input type="integer" name="practice_score" class="form-control" aria-describedby="practiceHelp" placeholder="Input nilai praktek">
                            <small id="practiceHelp" class="form-text text-muted">Range nilai 0-100</small>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <label>Nilai UAS</label>
                    <input type="integer" name="exam_score" class="form-control" aria-describedby="examHelp" placeholder="Input nilai uas">
                    <small id="examHelp" class="form-text text-muted">Range nilai 0-100</small>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
          </div>
          <div class="row" style="margin-top: 20px;">
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <th>Nilai Quiz</th>
                    <th>Nilai Tugas</th>
                    <th>Nilai Absensi</th>
                    <th>Nilai Praktek</th>
                    <th>Nilai UAS</th>
                    <th>Grade</th>
                </tr>
                @foreach ($grades as $grade)
                <tr>
                    <td>{{ $grade->student_name }}</td>
                    <td>{{ $grade->quiz_score }}</td>
                    <td>{{ $grade->task_score }}</td>
                    <td>{{ $grade->presence_score }}</td>
                    <td>{{ $grade->practice_score }}</td>
                    <td>{{ $grade->exam_score }}</td>
                    <td>{{ $grade->result }}</td>
                </tr>
                @endforeach
            </table>
          </div>
        </div>
    </body>

    <script>
        const ctx = document.getElementById('grading-chart');

        new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ['A', 'B', 'C', 'D'],
              datasets: [{
                label: 'Grade Score',
                data: {!! json_encode($scores) !!},
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
    </script>
</html>