<?php

/**
 * Note to module developers:
 *  Keeping a module specific language file like this
 *  in this external folder is not a good practise for
 *  portability - I do not advice you to do this for
 *  your own modules since they are non-default.
 *  Instead, simply put your language files in
 *  application/modules/yourModule/language/
 *  You do not need to change any code, the system
 *  will automatically look in that folder too.
 */


 /**
 * Suporte ao idioma Português do Brasil por DX-BR
 */

// UCP
$lang['user_panel'] = "Painel de Controle do Usuário";
$lang['account_overview'] = "Visão Geral da Conta";
$lang['account_characters'] = "Personagens da Conta";

$lang['nickname'] = "Apelido";
$lang['change_nickname'] = "Alterar Nome";

$lang['username'] = "Nome de usuário";

$lang['location'] = "Localização";
$lang['change_location'] = "Alterar Localização";

$lang['email'] = "E-mail";
$lang['change_email'] = "Alterar E-mail";

$lang['password'] = "Senha";
$lang['change_password'] = "Alterar Senha";

$lang['account_rank'] = "Rank da Conta";
$lang['voting_points'] = "Pontos de Voto";
$lang['donation_points'] = "Pontos de Doação";
$lang['account_status'] = "Status da Conta";
$lang['member_since'] = "Membro desde";
$lang['data_tip_vote'] = "Ganhe Pontos de Voto votando no Servidor";
$lang['data_tip_donate'] = "Ganhe Pontos de Doação doando para o Servidor";

$lang['edit'] = "Editar";

// Avatar
$lang['change_avatar'] = "Alterar avatar";
$lang['avatar_invalid'] = "O avatar selecionado é inválido.";
$lang['avatar_invalid_rank'] = "O avatar selecionado requer um ranking de usuário maior.";

// Settings
$lang['settings'] = "Configurações da Conta";

$lang['old_password'] = "Senha antiga";
$lang['new_password'] = "Nova senha";
$lang['new_password_confirm'] = "Confirmar senha";
$lang['new_password_submit'] = "Alterar senha";

$lang['nickname_error'] = "O apelido deve ter entre 4 e 14 caracteres e só pode conter letras e números";
$lang['location_error'] = "A localização pode ter até 32 caracteres e só pode conter letras";
$lang['pw_doesnt_match'] = "As senhas não coincidem!";
$lang['changes_saved'] = "As alterações foram salvas!";
$lang['invalid_pw'] = "Senha incorreta!";
$lang['nickname_taken'] = "O apelido já está em uso";
$lang['invalid_language'] = "Idioma inválido";

$lang['change_information'] = "Alterar informações";

// Security
$lang['account_security'] = "Segurança da Conta";
$lang['save_changes'] = "Salvar alterações";
$lang['two_factor'] = "AUTENTICAÇÃO DE DOIS FATORES";
$lang['two_factor_description'] = "A autenticação de dois fatores ajuda a proteger sua conta contra acessos não autorizados, adicionando uma camada adicional de segurança.";
$lang['two_factor_help'] = "Baixe o aplicativo Google Authenticator na Google Play Store ou App Store. Abra o aplicativo e use a câmera do seu telefone para escanear o código de barras abaixo. Insira o código de verificação de 6 dígitos gerado pelo aplicativo Authenticator.";
$lang['qr_code'] = "Código QR";
$lang['qr_code_help_1'] = "Não consegue escanear o código QR? Você também pode inserir";
$lang['qr_code_help_2'] = "a chave manualmente.";
$lang['select_authentication'] = "Selecione o método de autenticação";
$lang['disabled'] = "Desativado";
$lang['google_authenticator'] = "Google Authenticator";
$lang['six_digit_auth_code'] = "Código de Autenticador de 6 dígitos";
$lang['six_digit_not_empty'] = "O código de Autenticador de 6 dígitos não pode estar vazio";
$lang['six_digit_not_true'] = "O código de Autenticador não é válido";

// Recent Activity
$lang['recent_activity'] = 'Atividade recente';
$lang['account_login'] = 'Login da conta';
$lang['account_logout'] = 'Logout da conta';
$lang['account_recovery'] = 'Recuperação da conta';
$lang['service'] = 'Serviço';
$lang['character'] = 'Personagem';
$lang['amount'] = 'Quantidade';
$lang['ip'] = 'IP';
$lang['today'] = 'Hoje';
$lang['yesterday'] = 'Ontem';
