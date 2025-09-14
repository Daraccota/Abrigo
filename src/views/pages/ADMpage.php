<?php
// Configurações do banco de dados
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "abrigo_sao_francisco_de_assis";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

//consuta todos idosos
$sql= " SELECT * FROM idosos ORDER BY criado_em DESC";
$result = $conn->query($sql);

// array $idoso

$idoso = [];
if  ($result->num_rows > 0) {
  while($row= $result->fetch_assoc()){
    $idoso[] = $row;
  }
}

//logica para excuir 

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM idosos WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        header("Location: ADMpage.php?success=Perfil excluído com sucesso.");
    } else {
        header("Location: ADMpage.php?error=Erro ao excluir Perfil.");
    }
    exit();
}



?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Painel ADM • Abrigo São Francisco de Assis</title>
  <style>
    :root{
      --bg:#0f172a;          /* slate-900 */
      --panel:#111827;       /* gray-900 */
      --elev:#0b1226;        /* deep card */
      --muted:#94a3b8;       /* slate-400 */
      --text:#e5e7eb;        /* gray-200 */
      --brand:#6ee7b7;       /* emerald-300 */
      --brand-2:#60a5fa;     /* blue-400 */
      --accent:#a78bfa;      /* violet-400 */
      --danger:#ef4444;      /* red-500 */
      --warn:#f59e0b;        /* amber-500 */
      --ok:#22c55e;          /* green-500 */
      --radius:18px;
      --shadow:0 10px 30px rgba(0,0,0,.35);
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0; font:16px/1.4 system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, "Helvetica Neue", Arial; color:var(--text); background:
        radial-gradient(1200px 600px at -10% -10%, #1e3a8a22, transparent 50%),
        radial-gradient(1000px 500px at 120% 10%, #6d28d922, transparent 50%),
        var(--bg);
      display:grid; grid-template-columns:280px 1fr; grid-template-rows:64px 1fr; grid-template-areas:
        "sidebar header"
        "sidebar main";
    }
    /* Sidebar */
    .sidebar{grid-area:sidebar; position:sticky; top:0; height:100vh; padding:18px; background:linear-gradient(180deg, #0b1022, #0b1022cc 50%, #0b102200); border-right:1px solid #1f2937;}
    .brand{display:flex; align-items:center; gap:12px; margin-bottom:18px}
    .logo{width:38px; height:38px; border-radius:50%; background:conic-gradient(from 210deg, var(--brand), var(--accent), var(--brand-2)); box-shadow:0 0 0 3px #0b1022, 0 0 20px #7c3aed55}
    .brand h1{font-size:1.05rem; margin:0}
    .sub{color:var(--muted); font-size:.8rem}
    nav{margin-top:16px; display:flex; flex-direction:column; gap:6px}
    .nav-item{display:flex; align-items:center; gap:12px; padding:10px 12px; border-radius:12px; color:var(--text); text-decoration:none; background:transparent; transition:.2s ease; border:1px solid transparent}
    .nav-item svg{opacity:.85}
    .nav-item:hover{background:#0b1226; border-color:#1f2937; transform:translateY(-1px)}
    .nav-item.active{background:linear-gradient(180deg,#0f172acc,#0f172a); border-color:#334155; box-shadow:var(--shadow)}
    .foot{position:absolute; bottom:16px; left:16px; right:16px; color:var(--muted); font-size:.78rem}

    /* Header */
    .header{grid-area:header; display:flex; align-items:center; justify-content:space-between; padding:10px 18px; backdrop-filter:saturate(120%) blur(6px); background:#0b102288; border-bottom:1px solid #1f2937}
    .search{display:flex; align-items:center; gap:10px; padding:8px 12px; background:#0b1226; border:1px solid #1f2937; border-radius:999px; width:min(520px, 55vw)}
    .search input{flex:1; background:transparent; outline:none; border:0; color:var(--text)}
    .actions{display:flex; align-items:center; gap:10px}
    .btn{border:1px solid #334155; background:#0b1226; color:var(--text); padding:8px 12px; border-radius:12px; cursor:pointer; transition:.2s ease}
    .btn:hover{transform:translateY(-1px); border-color:#475569}

    /* Main */
    main{grid-area:main; padding:22px; overflow:auto}
    .grid{display:grid; gap:18px; grid-template-columns:repeat(12,1fr)}
    .card{grid-column:span 12; background:linear-gradient(180deg, #0b1022, #0b0f1a); border:1px solid #1f2937; border-radius:var(--radius); box-shadow:var(--shadow); padding:18px}
    .card h2{margin:0 0 12px; font-size:1.05rem}
    .muted{color:var(--muted)}
    .row{display:grid; gap:12px; grid-template-columns:repeat(12,1fr)}
    label{font-size:.9rem}
    input[type="text"], input[type="number"], input[type="date"], textarea, select{
      width:100%; padding:10px 12px; border-radius:12px; background:#0b1226; border:1px solid #1f2937; color:var(--text); outline:none
    }
    textarea{min-height:110px; resize:vertical}
    .hint{font-size:.78rem; color:var(--muted)}
    .pill{display:inline-flex; gap:8px; align-items:center; padding:6px 10px; background:#0b1226; border:1px dashed #334155; border-radius:999px; font-size:.8rem}
    .actions-row{display:flex; gap:10px; flex-wrap:wrap}
    .btn.primary{background:linear-gradient(135deg, var(--brand), var(--brand-2)); color:#0b1022; border-color:transparent; font-weight:600}
    .btn.warn{background:linear-gradient(135deg, #fde68a, #f59e0b); color:#0b1022; border-color:transparent; font-weight:600}
    .btn.danger{background:linear-gradient(135deg, #fecaca, #ef4444); color:#0b1022; border-color:transparent; font-weight:600}

    table{width:100%; border-collapse:separate; border-spacing:0 8px}
    th,td{padding:10px 12px; text-align:left}
    thead th{font-size:.8rem; color:var(--muted)}
    tbody tr{background:#0b1226; border:1px solid #1f2937}
    tbody tr td:first-child{border-top-left-radius:12px; border-bottom-left-radius:12px}
    tbody tr td:last-child{border-top-right-radius:12px; border-bottom-right-radius:12px}

    .badge{padding:4px 8px; border-radius:999px; font-size:.75rem}
    .badge.ok{background:#053f22; color:#a7f3d0; border:1px solid #064e3b}
    .badge.warn{background:#3d2a04; color:#fde68a; border:1px solid #92400e}

    .kpis{display:grid; grid-template-columns:repeat(4,1fr); gap:12px}
    .kpi{background:#0b1226; border:1px solid #1f2937; border-radius:16px; padding:14px}
    .kpi strong{display:block; font-size:1.3rem}

    .banner{padding:12px 14px; border-radius:12px; border:1px solid #334155; background:linear-gradient(90deg, #0b1226, #0b1226aa)}

    @media (max-width: 1024px){
      body{grid-template-columns:1fr; grid-template-areas:
        "header"
        "main"}
      .sidebar{display:none}
      .grid{grid-template-columns:repeat(6,1fr)}
      .row{grid-template-columns:repeat(6,1fr)}
      .kpis{grid-template-columns:repeat(2,1fr)}
    }
    @media (max-width: 640px){
      .grid,.row{grid-template-columns:repeat(4,1fr)}
      .kpis{grid-template-columns:1fr}
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="brand">
      <div class="logo" aria-hidden="true"></div>
      <div>
        <h1>Abrigo São Francisco de Assis</h1>
        <div class="sub">Painel Administrativo</div>
      </div>
    </div>
    
    

        <nav>
          <a class="nav-item active" href="#cadastro">
            <!-- user icon -->
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 7A4 4 0 1 1 8 7a4 4 0 0 1 8 0ZM4 19a8 8 0 1 1 16 0v1H4v-1Z" stroke="currentColor" stroke-width="1.5"/></svg>
            Cadastrar Idoso
          </a>
          <a class="nav-item" href="#perfis">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="1.5"/></svg>
            Perfis Cadastrados
          </a>
          <a class="nav-item" href="#comunicados">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 5h16v10H7l-3 3V5Z" stroke="currentColor" stroke-width="1.5"/></svg>
            Comunicados
          </a>
          <a class="nav-item" href="#eventos">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 3v3m10-3v3M4 9h16M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z" stroke="currentColor" stroke-width="1.5"/></svg>
            Eventos / Missas
          </a>
          <a class="nav-item" href="#transparencia">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16v12H4z" stroke="currentColor" stroke-width="1.5"/><path d="M8 10h8M8 14h6" stroke="currentColor" stroke-width="1.5"/></svg>
            Transparência
          </a>
          <a class="nav-item" href="#config">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m12 7 1 2 2 1-2 1-1 2-1-2-2-1 2-1 1-2Z" stroke="currentColor" stroke-width="1.5"/><path d="M19 12a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" stroke="currentColor" stroke-width="1.5"/></svg>
            Configurações
          </a>
        </nav>

    <div class="foot">Demonstração estática para layout e conteúdo. Integre depois ao seu backend.</div>
  </aside>

  <!-- Header -->
  <header class="header">
    <div class="search">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Zm10 2-5-5" stroke="currentColor" stroke-width="1.5"/></svg>
      <input type="text" placeholder="Buscar residente, evento ou documento..." aria-label="Buscar" />
    </div>
    <div class="actions">
      <button class="btn">Nova Missa</button>
      <button class="btn">Novo Evento</button>
      <button class="btn">Publicar Alerta</button>
    </div>
  </header>

  <!-- Main -->
  <main>
    <section class="grid">
      <!-- KPIs -->
      <div class="card" style="grid-column:span 12">
        <div class="kpis" role="group" aria-label="Indicadores">
          <div class="kpi"><div class="muted">Idosos cadastrados</div><strong>128</strong></div>
          <div class="kpi"><div class="muted">Perfis ativos</div><strong>124</strong></div>
          <div class="kpi"><div class="muted">Eventos no mês</div><strong>9</strong></div>
          <div class="kpi"><div class="muted">Documentos públicos</div><strong>23</strong></div>
        </div>
      </div>

      <!-- Cadastro de Idoso -->
       

          <div id="cadastro" class="card" style="grid-column:span 8">
            <form action="../../controllers/cadastraridosos.php" method="POST" enctype="multipart/form-data">

                <h2>Cadastro de Idoso</h2>
                <p class="muted">Preencha os dados do residente. Campos essenciais primeiro, mídias depois.</p>
                <div class="row" style="margin-top:10px">

                  <div style="grid-column:span 8">
                    <label for="nome">Nome completo</label>
                    <input id="nome" name="nome" type="text" placeholder="Ex.: João Batista de Lima" />
                  </div>

                  <div style="grid-column:span 2">
                    <label for="idade">Idade</label>
                    <input id="idade" name="idade" type="number" min="0" max="120" placeholder="Ex.: 78" />
                  </div>

                  <div style="grid-column:span 2">
                    <label for="cidade">Cidade de origem</label>
                    <input id="cidade_de_origem" name="cidade_de_origem" type="text" placeholder="Ex.: Palmares - PE" />
                  </div>

                  <div style="grid-column:span 6">
                    <label for="perfil">Imagem de perfil</label>
                    <input id="foto_perfil" name="foto_perfil" type="file" placeholder="Solte um arquivo aqui ou cole a URL" />
                    <div class="hint">Sugestão: 600x600px, JPG/PNG.</div>
                  </div>

                  <div style="grid-column:span 6">
                    <label>Fotos do dia a dia <span class="muted">(máx. 14)</span></label>
                    <div class="pill" aria-live="polite"><input type="file" id="fotos_diarias" name="fotos_diarias[]" multiple accept="image/*"></div>
                  </div>

                  <div style="grid-column:span 6">
                    <label>Vídeos do dia a dia <span class="muted">(máx. 4)</span></label>
                    <div class="pill"><input type="file" id="videos" name="videos[]" multiple accept="video/*"></div>
                  </div>

                  <div style="grid-column:span 6">
                    <label for="bio">Observações / biografia breve</label>
                    <textarea id="bio" name="bio" placeholder="Histórico, preferências, restrições alimentares, contatos de familiares..."></textarea>
                  </div>

                </div>
                
                <div class="actions-row" style="margin-top:12px">
                <!-- Botão padrão de salvar -->
                <button type="submit" class="btn primary" name="action" value="save">Salvar cadastro</button>

                
                <!-- Botão para limpar campos -->
                <button type="button" class="btn warn" onclick="limparCampos()">Limpar campos</button>
              </div>

              <script>
                function limparCampos() {
                  const form = document.querySelector('form');
                  form.reset(); // limpa todos os inputs
                  // opcional: limpar previews de imagens e vídeos se houver
                }
              </script>

            </form>
          </div>

      
<!-- Perfis Cadastrados -->
<div id="perfis" class="card" style="grid-column:span 4">
  <h2>Perfis Cadastrados</h2>
  <p class="muted">Visualize, edite ou exclua registros existentes.</p>
  <table aria-label="Lista de perfis">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Idade</th>
        <th>Status</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($idoso)): ?>
        <?php foreach ($idoso as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= htmlspecialchars($row['idade']) ?></td>
            <td><?= 'Ativo' ?></td>
            <td>
              <button class="btn" onclick="abrirModal(
                  '<?= htmlspecialchars($row['nome']) ?>',
                  '<?= $row['idade'] ?>',
                  '<?= htmlspecialchars($row['cidade_de_origem']) ?>',
                  'Ativo',
                  '<?= htmlspecialchars($row['bio']) ?>',
                  '<?= htmlspecialchars($row['foto_perfil']) ?>',
                  '<?= htmlspecialchars(json_encode($row['fotos_diarias'])) ?>',
                  '<?= htmlspecialchars(json_encode($row['videos'])) ?>'
              )">Ver</button>
              <a class="btn" href="editar_perfil_idoso.php?id=<?= $row['id'] ?>">Editar</a>

              <a class="btn danger" href="ADMpage.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este Perfil?');">
          <i class="bi bi-trash-fill"></i> Excluir
              
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" style="text-align:center; color:var(--muted)">Nenhum idoso cadastrado ainda.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <div class="actions-row" style="margin-top:10px">
    <a href="moradores_do_abrigo.php" class="btn">Ver todos</a>
    <button class="btn">Exportar CSV</button>
  </div>
</div>

        
        <div class="actions-row" style="margin-top:10px">
          <a href="moradores_do_abrigo.php" class="btn">Ver todos</a>
          <button class="btn">Exportar CSV</button>
        </div>
      </div>

      <!-- Comunicados -->
      <div id="comunicados" class="card" style="grid-column:span 6">
        <h2>Comunicados / Alertas públicos</h2>
        <p class="muted">Mensagens exibidas ao acessar o site.</p>
        <label for="alerta">Mensagem</label>
        <textarea id="alerta" placeholder="Ex.: A visitação estará suspensa no dia 12/10 para manutenção." ></textarea>
        <div class="actions-row" style="margin-top:10px">
          <button class="btn primary">Publicar</button>
          <button class="btn warn">Agendar</button>
        </div>
        <div class="banner" style="margin-top:12px">
          <strong>Pré-visualização:</strong>
          <div class="muted">Nenhuma mensagem publicada ainda.</div>
        </div>
      </div>

      <!-- Eventos / Missas -->
      <div id="eventos" class="card" style="grid-column:span 6">
        <h2>Eventos, Festividades e Missas</h2>
        <p class="muted">Gerencie celebrações, formações de cuidadores e horários da capela.</p>
        <div class="row">
          <div style="grid-column:span 5">
            <label for="tituloEvt">Título do evento</label>
            <input id="tituloEvt" type="text" placeholder="Ex.: Missa Nossa Senhora Aparecida" />
          </div>
          <div style="grid-column:span 3">
            <label for="dataEvt">Data</label>
            <input id="dataEvt" type="date" />
          </div>
          <div style="grid-column:span 2">
            <label for="horaEvt">Hora</label>
            <input id="horaEvt" type="text" placeholder="Ex.: 18:30" />
          </div>
          <div style="grid-column:span 2">
            <label for="tipoEvt">Tipo</label>
            <select id="tipoEvt">
              <option>Missas</option>
              <option>Festividades</option>
              <option>Formações</option>
              <option>Outros</option>
            </select>
          </div>
        </div>
        <div class="actions-row" style="margin-top:10px">
          <button class="btn primary">Adicionar ao calendário</button>
          <button class="btn">Exportar iCal</button>
        </div>
        <table style="margin-top:12px">
          <thead><tr><th>Data</th><th>Evento</th><th>Tipo</th><th>Ações</th></tr></thead>
          <tbody>
            <tr><td>12/10/2025 18:30</td><td>Missa de Nossa Senhora Aparecida</td><td>Missas</td><td><button class="btn">Editar</button> <button class="btn danger">Remover</button></td></tr>
            <tr><td>25/10/2025 09:00</td><td>Formação de Cuidadores (Cognitiva)</td><td>Formações</td><td><button class="btn">Editar</button> <button class="btn danger">Remover</button></td></tr>
          </tbody>
        </table>
      </div>

      

      <!-- Transparência Pública -->
      <div id="transparencia" class="card" style="grid-column:span 8">
        <h2>Transparência ao Público</h2>
        <p class="muted">Publique doações, relatórios financeiros e projetos em andamento.</p>
        <div class="row">
          <div style="grid-column:span 4">
            <label for="tipoDoc">Tipo de documento</label>
            <select id="tipoDoc">
              <option>Doações recebidas</option>
              <option>Relatório financeiro</option>
              <option>Prestação de contas</option>
              <option>Projetos</option>
            </select>
          </div>
          <div style="grid-column:span 8">
            <label for="descDoc">Descrição</label>
            <input id="descDoc" type="text" placeholder="Ex.: Relatório Financeiro – 3º Trimestre/2025" />
          </div>
          <div style="grid-column:span 12">
            <label>Arquivo</label>
            <div class="pill">Solte aqui o PDF/Planilha ou clique para enviar</div>
            <div class="hint">Formatos aceitos: PDF, XLSX, CSV. Tamanho máximo sugerido: 10MB.</div>
          </div>
        </div>
        <div class="actions-row" style="margin-top:10px">
          <button class="btn primary">Publicar documento</button>
          <button class="btn">Criar link público</button>
        </div>
        <table style="margin-top:12px">
          <thead><tr><th>Data</th><th>Título</th><th>Tipo</th><th>Link</th><th>Ações</th></tr></thead>
          <tbody>
            <tr><td>05/09/2025</td><td>Relatório Financeiro – 2º Tri/2025</td><td>Relatório financeiro</td><td><span class="badge ok">Publicado</span></td><td><button class="btn">Ver</button> <button class="btn">Editar</button> <button class="btn danger">Excluir</button></td></tr>
            <tr><td>18/08/2025</td><td>Doações Recebidas – Agosto/2025</td><td>Doações</td><td><span class="badge ok">Publicado</span></td><td><button class="btn">Ver</button> <button class="btn">Editar</button> <button class="btn danger">Excluir</button></td></tr>
          </tbody>
        </table>
      </div>

      <!-- Configurações / Acessibilidade -->
      <div id="config" class="card" style="grid-column:span 4">
        <h2>Configurações</h2>
        <div class="row">
          <div style="grid-column:span 12">
            <label for="tema">Tema de contraste</label>
            <select id="tema">
              <option>Escuro (padrão)</option>
              <option>Claro</option>
              <option>Alto contraste</option>
            </select>
          </div>
          <div style="grid-column:span 12">
            <label for="acess">Acessibilidade</label>
            <div class="pill">Atalhos de teclado • Rótulos ARIA • Tamanhos de fonte ajustáveis</div>
          </div>
        </div>
        <div class="actions-row" style="margin-top:12px">
          <button class="btn">Salvar preferências</button>
        </div>
      </div>
    </section>
  </main>
        <!-- scripts e div para o botão "ver" -->
    <div id="modalDetalhes" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
      <div style="background:var(--panel); padding:20px; border-radius:var(--radius); max-width:500px; width:90%; position:relative;">
        <button onclick="fecharModal()" style="position:absolute; top:10px; right:10px;">✖</button>
        <h3 id="modalNome"></h3>
        <p><strong>Idade:</strong> <span id="modalIdade"></span></p>
        <p><strong>Cidade de origem:</strong> <span id="modalCidade"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
        <p><strong>Bio:</strong> <span id="modalBio"></span></p>
        <img id="modalFoto" src="" alt="" style="width:100%; max-height:200px; object-fit:cover; margin-top:10px; border-radius:12px">
      </div>
    </div>

  <script>
      function abrirModal(nome, idade, cidade, status, bio, foto) {
        document.getElementById('modalNome').innerText = nome;
        document.getElementById('modalIdade').innerText = idade;
        document.getElementById('modalCidade').innerText = cidade;
        document.getElementById('modalStatus').innerText = status;
        document.getElementById('modalBio').innerText = bio;
        document.getElementById('modalFoto').src = foto ? foto : '';
        document.getElementById('modalDetalhes').style.display = 'flex';
      }

      function fecharModal() {
        document.getElementById('modalDetalhes').style.display = 'none';
      }
</script>


</script>


</body>
</html>

