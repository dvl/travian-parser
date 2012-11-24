<form class="form-horizontal" action="" method="POST">
	<div class="control-group">
		<label class="control-label">Titulo:</label>
		<div class="controls">
			<input type="text" name=info[titulo] placeholder="2º Servidor pt5" required>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Data de Inicio</label>
		<div class="controls">
			<div class="input-append date datapicker" data-date="12/02/2012" data-date-format="dd/mm/yyyy">
				<input class="span2" size="16" name=info[inicio] type="text" value="12/02/2012" readonly required>
				<span class="add-on"><i class="icon-calendar"></i></span>
			</div>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Data de Fim</label>
		<div class="controls">
			<div class="input-append date datapicker" data-date="12/12/2012" data-date-format="dd/mm/yyyy">
				<input class="span2" size="16" name="info[fim]" type="text" value="12/12/2012" readonly required>
				<span class="add-on"><i class="icon-calendar"></i></span>
			</div>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Servidor</label>
		<div class="controls">
			<select name="server" class="span2" required>
				<option value="http://ts2.travian.com.br/">Travian br2</option>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Usuário</label>
		<div class="controls">
			<input type="text" name="name" placeholder="Usuário" required>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Senha</label>
		<div class="controls">
			<input type="password" name="password" placeholder="Senha" required>
		</div>
	</div>
	<div class="form-actions">
		<button class="btn-primary btn" type="submit">Enviar</button> <button class="btn-danger btn" type="reset">Limpar</button>
	</div>
</form>