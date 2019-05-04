{$this->Form->create($order,['enctype' => 'multipart/form-data', 'url' => [ 'controller' => 'orders','action' => 'input']])}
{$this->Form->input('order_date')}
{$this->Form->input('items.0.item_name')}
{$this->Form->input('items.0.item_price')}
{$this->Form->button('登録')}
{$this->Form->end()}