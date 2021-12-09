# Programa Conecta Garopaba - Wifi Público

## Sobre
O programa tem por objetivo fornecer internet sem fio gratuita para moradores e visitantes da cidade. Os pontos de internet ficam disponíveis em praias, praças e demais locais com alto fluxo de pessoas.

## Requisitos Técnicos
- Servidor com sistema operacional Linux, com os serviços de Radius e MySQL configurados;
- Equipamento concentrador, responsável pela configuração e gerenciamento de cada ponto. Para o Programa Conecta Garopaba, foi utilizado o roteador Mikrotik CCR1009-7G-1C-1S+;
- Equipamento de acesso (antena) em cada ponto de internet, responsável pela distribuição do sinal de rede no local. Para o Programa Conecta Garopaba, foi utilizado o roteador Mikrotik mANTBox 15s ( RB921GS-5HPacD-15S );
- Comunicação física e lógica entre o equipamento concentrador e os equipamentos de acesso (antena);

## Funcionamento
- O cidadão vai até qualquer ponto de wifi público da cidade. Ele então conecta na rede configurada. Neste caso, e rede é denominada "Conecta Garopaba".
- Após conectar, é aberto o formulário de login, permitindo também o cadastro para o primeiro acesso.
- Realizado o login, a conexão de internet é liberada pelo tempo limite e na velocidade configurada no equipamento concentrador.
