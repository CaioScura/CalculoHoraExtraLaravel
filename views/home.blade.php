<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cálculo de Horas Extras</title>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 style="margin-top: 50px;">Cálculo de Horas Extras</h1>
            </div>
        </div>
    </div>
    <div class="text-block black-box" style="background-color:rgba(240,240,240)">
        <div class="container calculator-container">
{{--            "{{ route('processar') }}"--}}
        <form  id="meuFormulario" name="FormCalculo">  <!-- Definindo a rota e método POST -->
                @csrf <!-- Adicionando o token CSRF (para proteção) -->
                <br>

                <!-- Campos do formulário -->
                <div class="row form-group">
                    <div class="col-md-3">
                        <label class="control-label">Salário Bruto</label>
                    </div>
                    <div class="col-md-3" style="width: 39%">
                        <div class="input-group">
                            <span class="input-group-addon"></span>
                            <input id="salarioBruto" name="salarioBruto" type="text" class="form-control" aria-label="" placeholder="R$ 2500,00" required="">
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-3">
                        <label class="control-label">Carga horária(Mensal)</label>
                    </div>
                    <div class="col-md-3" style="width: 39%">
                        <input name="cargaHoraria" type="text" class="form-control" placeholder="220" required>
                        <span class="input-group-addon"></span>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-3">
                        <label class="control-label">Quantidade de Horas Extras</label>
                    </div>
                    <div class="col-md-3" style="width: 39%">
                        <input name="QtdHE" type="time" class="form-control" placeholder="hh:mm" required>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-3">
                        <label class="control-label">% da Hora Extra</label>
                    </div>
                    <div class="col-md-3" style="width: 39%">
                        <input name="porcHE" type="text" class="form-control" placeholder="75%" required>
                        <span class="input-group-addon"></span>
                    </div>
                </div>

                <!-- Botão para enviar o formulário -->
                <div class="row form-group">
                    <div class="col-md-8">
                    <button id="btnCalcular" type="submit" class="btn btn-primary">Calcular</button>

                    </div>
                </div>
            </form>
        </div>
    </div>


<br>


<div id="tabelaResultado" class="container resultado-container">

        <div class="resultado">
            <div class="col-8">
                <h1    > RESULTADO</h1>

                <table class="table table-hover">

                    <tbody>
                         <tr>
                            <td class="col-md-4">Salário Bruto</td>
                            <td class="col-md-4">{{ isset($salarioBruto)  ? $salarioBruto : 'Valor padrão se não houver dado' }}</td>
                        </tr>
                        <tr>
                        <td class="col-md-4">Carga horária mensal</td>
                        <td class="col-md-4">{{ isset($cargaHoraria)}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Quantidade de horas extras</td>
                        <td class="col-md-4">{{ isset($QtdHE)}}</td>
                    </tr> 
                    <tr>
                        <td class="col-md-4">% das horas extras</td>
                        <td class="col-md-4">{{ isset($porcHE)}}</td>
                    </tr> 
                    <tr>
                        <td class="col-md-4">Salário Hora</td>
                        <td class="col-md-4">{{ isset($salarioHora)}}</td>
                    </tr>  
                    <tr>
                        <td class="col-md-4">Valor das horas extras</td>
                        <td class="col-md-4">salariob</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
</div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
    <script Src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <script>
        $(function (){
            $('form[name="FormCalculo"]').submit(function(event){
                event.preventDefault();
                $.ajax({
                    url: "{{ route('processar') }}",
                    type: "post",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response){
                        if(response.success === true){
                            // Atualiza a view com os dados retornados
                            $('#tabelaResultado tbody tr:nth-child(1) td:nth-child(2)').text(response.salarioBruto); 
                            $('#tabelaResultado tbody tr:nth-child(2) td:nth-child(2)').text(response.cargaHoraria); 
                            $('#tabelaResultado tbody tr:nth-child(3) td:nth-child(2)').text(response.QtdHE); 
                            $('#tabelaResultado tbody tr:nth-child(4) td:nth-child(2)').text(response.porcHE); 
                            $('#tabelaResultado tbody tr:nth-child(5) td:nth-child(2)').text(response.salarioHora);  
                            $('#tabelaResultado tbody tr:nth-child(6) td:nth-child(2)').text(response.valorHE);


                            // ... adicione aqui o código para atualizar os outros campos
                        } else {
                            alert('Erro!');
                        }
                    }
                });
            });
        });  
         
        document.addEventListener('DOMContentLoaded', function() {
        var salarioInput = document.querySelectorAll('input[name="salarioBruto"]');
        salarioInput.forEach(function(input) {
            input.addEventListener('input', function(e) {
                // Remove caracteres não numéricos
                var valor = e.target.value.replace(/\D/g, '');

                // Converte para formato monetário sem o símbolo
                valor = (parseFloat(valor) / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2 });

                // Define o valor formatado de volta no campo
                e.target.value = valor;
            });
        });
    });
    </script>  
      

    

</body>

</html>
<style>
    #tabelaResultado.active{display: block}
    #tabelaResultado{display: none}
</style>
<script>



    // Obtém o formulário pelo ID
    const formulario = document.getElementById('meuFormulario');
    // Adiciona um event listener para o evento de submissão do formulário
    formulario.addEventListener('submit', function(event) {
        // Exibe a tabela de resultado após o envio do formulário
        // event.preventDefault();
        document.getElementById('tabelaResultado').classList.add('active');
    });
</script>
