# Flux UI Documentation for LLMs

## Design Patterns

### Props vs Attributes
- **Props**: Flux-provided properties (e.g., `variant="primary"`)
- **Attributes**: Forwarded to HTML elements (e.g., `x-on:change.prevent="..."`)

### Class Merging
- Custom classes merge with Flux classes automatically
- Use `!` modifier for conflicts: `class="bg-zinc-800! hover:bg-zinc-700!"`
- Alternatives: publish components, global styling, or new components

### Common Props
- **variant**: Visual style variations
- **icon**: Heroicons name (e.g., `icon="magnifying-glass"`)
- **icon:trailing**: Icon at end instead of beginning
- **size**: Size variations (`sm`, `lg`, etc.)
- **kbd**: Keyboard shortcut hints (`kbd="⌘S"`)
- **inset**: Negative margins for alignment
- **keep-open**: Prevent menu/dropdown closing

### Component Groups
- Standalone groups: `.group` suffix (e.g., `<flux:button.group>`)
- Parent-child: `.item` suffix (e.g., `<flux:menu><flux:menu.item>`)

### Data Binding
Standard Livewire patterns work:
```php
<flux:input wire:model="email" />
<flux:checkbox wire:model="terms" />
<flux:select wire:model="state" />
```

## Components

### Badge
Highlight information like status, category, or count.

```php
<flux:badge color="lime">New</flux:badge>
<flux:badge size="sm">Small</flux:badge>
<flux:badge variant="pill" icon="user">Users</flux:badge>
<flux:badge variant="solid" color="red">Alert</flux:badge>
<flux:badge inset="top bottom">Inline</flux:badge>
<flux:badge as="button">Clickable</flux:badge>

<!-- With close button -->
<flux:badge>
    Admin <flux:badge.close />
</flux:badge>
```

**Props**:
- `color`: zinc, red, orange, amber, yellow, lime, green, emerald, teal, cyan, sky, blue, indigo, violet, purple, fuchsia, pink, rose (default: zinc)
- `size`: sm, lg
- `variant`: pill, solid
- `icon`: Heroicon name
- `icon:trailing`: Heroicon name
- `icon:variant`: outline, solid, mini, micro (default: mini)
- `as`: button, div (default: div)
- `inset`: top, bottom, left, right (or combinations)

### Button
Interactive controls for forms and UI actions.

```php
<flux:button>Default</flux:button>
<flux:button variant="primary">Primary</flux:button>
<flux:button variant="danger">Danger</flux:button>
<flux:button size="sm">Small</flux:button>
<flux:button icon="plus">With Icon</flux:button>
<flux:button icon:trailing="chevron-down">Trailing</flux:button>
<flux:button square>Square</flux:button>
<flux:button href="https://example.com">Link</flux:button>
<flux:button loading="false">No Loading</flux:button>

<!-- Button groups -->
<flux:button.group>
    <flux:button>First</flux:button>
    <flux:button>Second</flux:button>
</flux:button.group>
```

**Props**:
- `variant`: outline, primary, filled, danger, ghost, subtle (default: outline)
- `size`: base, sm, xs (default: base)
- `icon`: Heroicon name
- `icon:trailing`: Heroicon name
- `icon:variant`: outline, solid, mini, micro (default: micro)
- `square`: boolean
- `inset`: top, bottom, left, right (or combinations)
- `loading`: boolean (default: true)
- `tooltip`: string
- `kbd`: string
- `as`: button, a, div (default: button)
- `href`: URL (when as="a")
- `type`: button, submit (default: button)
- `color`: zinc, red, orange, amber, yellow, lime, green, emerald, teal, cyan, sky, blue, indigo, violet, purple, fuchsia, pink, rose

### Callout
Highlight important information or guide users toward key actions.

```php
<flux:callout icon="clock">
    <flux:callout.heading>Maintenance</flux:callout.heading>
    <flux:callout.text>
        Scheduled maintenance Sunday 2-5 AM UTC.
        <flux:callout.link href="#">Learn more</flux:callout.link>
    </flux:callout.text>
</flux:callout>

<!-- With actions -->
<flux:callout icon="clock" variant="warning">
    <flux:callout.heading>Subscription expiring</flux:callout.heading>
    <flux:callout.text>Renew to avoid interruption.</flux:callout.text>
    <x-slot name="actions">
        <flux:button>Renew now</flux:button>
        <flux:button variant="ghost">View plans</flux:button>
    </x-slot>
</flux:callout>

<!-- Dismissible -->
<flux:callout x-data="{ visible: true }" x-show="visible">
    <flux:callout.heading>Notice</flux:callout.heading>
    <x-slot name="controls">
        <flux:button icon="x-mark" variant="ghost" x-on:click="visible = false" />
    </x-slot>
</flux:callout>
```

**Props**:
- `icon`: Heroicon name
- `icon:variant`: outline, solid, mini, micro (default: mini)
- `variant`: secondary, success, warning, danger (default: secondary)
- `color`: zinc, red, orange, amber, yellow, lime, green, emerald, teal, cyan, sky, blue, indigo, violet, purple, fuchsia, pink, rose
- `inline`: boolean (default: false)
- `heading`: string (shorthand for flux:callout.heading)
- `text`: string (shorthand for flux:callout.text)

### Checkbox
Select one or multiple options from a set.

```php
<flux:checkbox wire:model="terms" label="I agree" />

<!-- Checkbox group -->
<flux:checkbox.group wire:model="notifications" label="Notifications">
    <flux:checkbox label="Push notifications" value="push" checked />
    <flux:checkbox label="Email" value="email" />
    <flux:checkbox label="SMS" value="sms" disabled />
</flux:checkbox.group>

<!-- With descriptions -->
<flux:checkbox 
    value="admin"
    label="Administrator"
    description="Full system access"
    checked
/>

<!-- Check-all functionality -->
<flux:checkbox.group>
    <flux:checkbox.all />
    <flux:checkbox checked />
    <flux:checkbox />
</flux:checkbox.group>
```

**Props**:
- `wire:model`: Livewire property name
- `label`: string
- `description`: string
- `value`: mixed
- `checked`: boolean
- `disabled`: boolean
- `invalid`: boolean
- `indeterminate`: boolean
- `variant`: default, cards, pills, buttons (Pro variants)
- `icon`: Heroicon name (for card/button variants)

### Dropdown
Composable dropdown with navigation menus and complex action menus.

```php
<flux:dropdown>
    <flux:button icon:trailing="chevron-down">Options</flux:button>
    <flux:menu>
        <flux:menu.item icon="plus">New post</flux:menu.item>
        <flux:menu.separator />
        <flux:menu.submenu heading="Sort by">
            <flux:menu.radio.group>
                <flux:menu.radio checked>Name</flux:menu.radio>
                <flux:menu.radio>Date</flux:menu.radio>
            </flux:menu.radio.group>
        </flux:menu.submenu>
        <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>
    </flux:menu>
</flux:dropdown>

<!-- Navigation menu -->
<flux:dropdown position="bottom" align="end">
    <flux:profile avatar="/img/user.png" name="User" />
    <flux:navmenu>
        <flux:navmenu.item href="#" icon="user">Account</flux:navmenu.item>
        <flux:navmenu.item href="#" icon="arrow-right-start-on-rectangle">Logout</flux:navmenu.item>
    </flux:navmenu>
</flux:dropdown>
```

**Props**:
- `position`: top, right, bottom, left (default: bottom)
- `align`: start, center, end (default: start)
- `offset`: number in pixels (default: 0)
- `gap`: number in pixels (default: 4)

### Field
Encapsulate input elements with labels, descriptions, and validation.

```php
<flux:field>
    <flux:label>Email</flux:label>
    <flux:input wire:model="email" type="email" />
    <flux:error name="email" />
</flux:field>

<!-- Shorthand -->
<flux:input wire:model="email" label="Email" type="email" />

<!-- With badge -->
<flux:field>
    <flux:label badge="Required">Email</flux:label>
    <flux:input type="email" required />
    <flux:error name="email" />
</flux:field>

<!-- Fieldset -->
<flux:fieldset>
    <flux:legend>Shipping address</flux:legend>
    <div class="space-y-6">
        <flux:input label="Street address" />
        <flux:input label="City" />
    </div>
</flux:fieldset>
```

**Props**:
- `variant`: block, inline (default: block)

### Input
Capture user data with various forms of text input.

```php
<flux:input label="Username" description="Publicly displayed" />
<flux:input type="email" placeholder="Enter email" />
<flux:input type="password" viewable />
<flux:input type="file" multiple />
<flux:input size="sm" />
<flux:input variant="filled" readonly />
<flux:input icon="magnifying-glass" placeholder="Search" />
<flux:input icon:trailing="credit-card" />
<flux:input kbd="⌘K" />
<flux:input clearable copyable />
<flux:input mask="(999) 999-9999" />
<flux:input as="button" placeholder="Search..." />

<!-- Input groups -->
<flux:input.group>
    <flux:input.group.prefix>https://</flux:input.group.prefix>
    <flux:input placeholder="example.com" />
</flux:input.group>

<flux:input.group>
    <flux:input placeholder="Amount" />
    <flux:button>Submit</flux:button>
</flux:input.group>
```

**Props**:
- `type`: text, email, password, file, date, etc. (default: text)
- `size`: sm, xs
- `variant`: outline, filled (default: outline)
- `icon`: Heroicon name
- `icon:trailing`: Heroicon name
- `kbd`: string (keyboard shortcut hint)
- `clearable`: boolean
- `copyable`: boolean
- `viewable`: boolean (for password inputs)
- `mask`: string (Alpine mask pattern)
- `as`: input, button (default: input)
- `class:input`: string (CSS classes for input element)
- `multiple`: boolean (for file inputs)
- `disabled`: boolean
- `readonly`: boolean
- `invalid`: boolean
- `wire:model`: Livewire property name
- `label`: string
- `description`: string
- `description:trailing`: string
- `badge`: string
- `placeholder`: string

### Modal
Display content in a layer above the main page.

```php
<flux:modal.trigger name="edit-profile">
    <flux:button>Edit profile</flux:button>
</flux:modal.trigger>

<flux:modal name="edit-profile" class="md:w-96">
    <div class="space-y-6">
        <flux:heading size="lg">Update profile</flux:heading>
        <flux:input label="Name" />
        <div class="flex">
            <flux:spacer />
            <flux:button variant="primary">Save</flux:button>
        </div>
    </div>
</flux:modal>

<!-- Flyout variant -->
<flux:modal name="settings" variant="flyout" position="right">
    <!-- Content -->
</flux:modal>

<!-- Data binding -->
<flux:modal wire:model.self="showModal">
    <!-- Content -->
</flux:modal>

<!-- Events -->
<flux:modal @close="handleClose" @cancel="handleCancel">
    <!-- Content -->
</flux:modal>
```

**Control from Livewire**:
```php
Flux::modal('confirm')->show();
Flux::modal('confirm')->close();
$this->modal('confirm')->show();
```

**Control from Alpine**:
```javascript
$flux.modal('confirm').show()
$flux.modal('confirm').close()
```

**Props**:
- `name`: string (unique identifier)
- `variant`: default, flyout, bare
- `position`: right, left, bottom (default: right, for flyout)
- `dismissible`: boolean (default: true)
- `wire:model`: Livewire property name

### Radio
Select one option from mutually exclusive choices.

```php
<flux:radio.group wire:model="payment" label="Payment method">
    <flux:radio value="cc" label="Credit Card" checked />
    <flux:radio value="paypal" label="PayPal" />
    <flux:radio value="ach" label="Bank transfer" />
</flux:radio.group>

<!-- With descriptions -->
<flux:radio
    value="admin"
    label="Administrator"
    description="Full system access"
/>

<!-- Segmented variant -->
<flux:radio.group variant="segmented" size="sm">
    <flux:radio label="Admin" icon="wrench" />
    <flux:radio label="Editor" icon="pencil-square" />
    <flux:radio label="Viewer" icon="eye" />
</flux:radio.group>
```

**Props**:
- `wire:model`: Livewire property name
- `label`: string
- `description`: string
- `variant`: default, segmented, cards, pills, buttons (Pro variants)
- `size`: base, sm (for segmented)
- `icon`: Heroicon name (for segmented/card variants)
- `disabled`: boolean
- `invalid`: boolean
- `indicator`: boolean (default: true, for card variants)

### Select
Choose a single option from a dropdown list.

```php
<flux:select wire:model="industry" placeholder="Choose industry...">
    <flux:select.option>Photography</flux:select.option>
    <flux:select.option>Web development</flux:select.option>
    <flux:select.option>Consulting</flux:select.option>
</flux:select>

<!-- Custom listbox -->
<flux:select variant="listbox" placeholder="Choose..." clearable>
    <flux:select.option>
        <div class="flex items-center gap-2">
            <flux:icon.shield-check variant="mini" /> Owner
        </div>
    </flux:select.option>
</flux:select>

<!-- Searchable -->
<flux:select variant="listbox" searchable multiple>
    <flux:select.option>Option 1</flux:select.option>
    <flux:select.option>Option 2</flux:select.option>
</flux:select>

<!-- Combobox -->
<flux:select variant="combobox" :filter="false">
    <x-slot name="input">
        <flux:select.input wire:model.live="search" />
    </x-slot>
    @foreach ($users as $user)
        <flux:select.option value="{{ $user->id }}">{{ $user->name }}</flux:select.option>
    @endforeach
</flux:select>
```

**Props**:
- `variant`: default, listbox, combobox
- `multiple`: boolean (listbox only)
- `searchable`: boolean (listbox/combobox only)
- `clearable`: boolean (listbox/combobox only)
- `filter`: boolean (default: true, combobox only)
- `selected-suffix`: string (default: " selected", listbox multiple)
- `clear`: select, close (default: select)
- `indicator`: default, checkbox (for multiple listbox)
- `size`: sm, xs
- `disabled`: boolean
- `invalid`: boolean
- `wire:model`: Livewire property name
- `placeholder`: string
- `label`: string
- `description`: string
- `description:trailing`: string
- `badge`: string

### Table
Display structured data in a condensed, searchable format.

```php
<flux:table :paginate="$this->orders">
    <flux:table.columns>
        <flux:table.column>Customer</flux:table.column>
        <flux:table.column sortable :sorted="$sortBy === 'date'" :direction="$sortDirection" wire:click="sort('date')">Date</flux:table.column>
        <flux:table.column>Amount</flux:table.column>
    </flux:table.columns>
    <flux:table.rows>
        @foreach ($this->orders as $order)
            <flux:table.row :key="$order->id">
                <flux:table.cell class="flex items-center gap-3">
                    <flux:avatar size="xs" src="{{ $order->avatar }}" />
                    {{ $order->customer }}
                </flux:table.cell>
                <flux:table.cell>{{ $order->date }}</flux:table.cell>
                <flux:table.cell variant="strong">{{ $order->amount }}</flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
```

**Props**:
- `paginate`: Laravel paginator instance

### Tabs
Organize content into separate panels within a single container.

```php
<flux:tab.group>
    <flux:tabs wire:model="tab">
        <flux:tab name="profile" icon="user">Profile</flux:tab>
        <flux:tab name="account" icon="cog-6-tooth">Account</flux:tab>
        <flux:tab name="billing" icon="banknotes">Billing</flux:tab>
    </flux:tabs>
    <flux:tab.panel name="profile">Profile content</flux:tab.panel>
    <flux:tab.panel name="account">Account content</flux:tab.panel>
    <flux:tab.panel name="billing">Billing content</flux:tab.panel>
</flux:tab.group>

<!-- Segmented variant -->
<flux:tabs variant="segmented" size="sm">
    <flux:tab icon="list-bullet">List</flux:tab>
    <flux:tab icon="squares-2x2">Board</flux:tab>
</flux:tabs>

<!-- Pills variant -->
<flux:tabs variant="pills">
    <flux:tab>List</flux:tab>
    <flux:tab>Board</flux:tab>
</flux:tabs>
```

**Props**:
- `variant`: default, segmented, pills
- `size`: base, sm (default: base)
- `wire:model`: Livewire property name

### Toast
Temporary notifications with feedback about actions or events.

```php
<!-- Include in layout -->
<flux:toast />
<!-- or with persistence -->
@persist('toast')
    <flux:toast />
@endpersist

<!-- Positioning -->
<flux:toast position="top right" class="pt-24" />
```

**From Livewire**:
```php
Flux::toast('Changes saved');
Flux::toast(
    heading: 'Success!',
    text: 'Changes saved successfully',
    variant: 'success',
    duration: 3000
);
```

**From Alpine**:
```javascript
$flux.toast('Changes saved')
$flux.toast({
    heading: 'Success!',
    text: 'Changes saved',
    variant: 'success'
})
```

**Props**:
- `position`: "bottom right", "bottom left", "top right", "top left" (default: "bottom right")
- `duration`: number in milliseconds (default: 5000, use 0 for permanent)
- `variant`: success, warning, danger

### Rich Text Editor
Basic rich text editor built with ProseMirror and Tiptap.

```php
<flux:editor wire:model="content" label="Content" description="Write your content" />

<!-- Custom toolbar -->
<flux:editor toolbar="heading | bold italic underline | align ~ undo redo" />

<!-- Custom height -->
<flux:editor class="**:data-[slot=content]:min-h-[100px]!" />

<!-- Full customization -->
<flux:editor>
    <flux:editor.toolbar>
        <flux:editor.heading />
        <flux:editor.separator />
        <flux:editor.bold />
        <flux:editor.italic />
        <flux:editor.spacer />
        <flux:dropdown>
            <flux:editor.button icon="ellipsis-horizontal" tooltip="More" />
            <flux:menu>
                <flux:menu.item>Preview</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:editor.toolbar>
    <flux:editor.content />
</flux:editor>
```

**Props**:
- `toolbar`: string (space-separated list: "heading | bold italic underline | align ~ undo redo")
- `placeholder`: string
- `disabled`: boolean
- `invalid`: boolean
- `wire:model`: Livewire property name
- `value`: string (initial content)
- `label`: string
- `description`: string
- `description:trailing`: string
- `badge`: string

### Textarea
Multi-line text input for longer content.

```php
<flux:textarea label="Description" placeholder="Enter description..." />
<flux:textarea rows="2" />
<flux:textarea rows="auto" />
<flux:textarea resize="none" />
<flux:textarea resize="vertical" />
```

**Props**:
- `rows`: number or "auto" (default: 4)
- `resize`: vertical, horizontal, both, none (default: vertical)
- `placeholder`: string
- `label`: string
- `description`: string
- `description:trailing`: string
- `badge`: string
- `invalid`: boolean
- `wire:model`: Livewire property name

### Switch
Toggle settings on or off for binary options.

```php
<flux:field variant="inline">
    <flux:label>Enable notifications</flux:label>
    <flux:switch wire:model.live="notifications" />
</flux:field>

<!-- With description -->
<flux:switch 
    wire:model.live="marketing" 
    label="Marketing emails" 
    description="Receive product updates" 
/>

<!-- Left aligned -->
<flux:switch label="Setting" align="left" />
```

**Props**:
- `wire:model`: Livewire property name
- `label`: string
- `description`: string
- `align`: right, start, left, end (default: right/start)
- `disabled`: boolean

## Advanced Components

### Accordion
Collapse and expand sections of content.

```php
<flux:accordion transition exclusive>
    <flux:accordion.item expanded>
        <flux:accordion.heading>What's your refund policy?</flux:accordion.heading>
        <flux:accordion.content>30-day money-back guarantee.</flux:accordion.content>
    </flux:accordion.item>
    <flux:accordion.item disabled>
        <flux:accordion.heading>Bulk discounts?</flux:accordion.heading>
        <flux:accordion.content>Contact sales team.</flux:accordion.content>
    </flux:accordion.item>
</flux:accordion>

<!-- Shorthand -->
<flux:accordion.item heading="Question?" expanded>
    Answer content here.
</flux:accordion.item>
```

**Props**:
- `variant`: default, reverse (icon position)
- `transition`: boolean (default: false)
- `exclusive`: boolean (default: false)

**Item Props**:
- `heading`: string (shorthand)
- `expanded`: boolean (default: false)
- `disabled`: boolean (default: false)

### Autocomplete
Enhanced input with autocomplete suggestions.

```php
<flux:autocomplete wire:model="state" label="State">
    <flux:autocomplete.item>California</flux:autocomplete.item>
    <flux:autocomplete.item>Texas</flux:autocomplete.item>
    <flux:autocomplete.item disabled>New York</flux:autocomplete.item>
</flux:autocomplete>
```

**Props**:
- `wire:model`: Livewire property name
- `type`: text, email, password, file, date, etc. (default: text)
- `label`: string
- `description`: string
- `placeholder`: string
- `size`: sm, xs
- `variant`: outline, filled (default: outline)
- `disabled`: boolean
- `readonly`: boolean
- `invalid`: boolean
- `multiple`: boolean (for file inputs)
- `mask`: string (Alpine mask pattern)
- `icon`: Heroicon name
- `icon:trailing`: Heroicon name
- `kbd`: string
- `clearable`: boolean
- `copyable`: boolean
- `viewable`: boolean
- `as`: input, button (default: input)
- `class:input`: string

### Breadcrumbs
Navigation hierarchy display.

```php
<flux:breadcrumbs>
    <flux:breadcrumbs.item href="#" icon="home">Home</flux:breadcrumbs.item>
    <flux:breadcrumbs.item href="#">Blog</flux:breadcrumbs.item>
    <flux:breadcrumbs.item>Post Title</flux:breadcrumbs.item>
</flux:breadcrumbs>
```

**Item Props**:
- `href`: string (URL)
- `icon`: Heroicon name

### Card
Container for related content.

```php
<flux:card class="space-y-6">
    <flux:heading size="lg">Card Title</flux:heading>
    <flux:text>Card content goes here.</flux:text>
    <flux:button variant="primary">Action</flux:button>
</flux:card>

<!-- Small card -->
<flux:card size="sm">
    <flux:heading>Compact card</flux:heading>
    <flux:text class="mt-2">Brief content.</flux:text>
</flux:card>
```

**Props**:
- `size`: base, sm (default: base)

### Heading
Consistent heading component.

```php
<flux:heading>Default heading</flux:heading>
<flux:heading size="lg">Large heading</flux:heading>
<flux:heading size="xl">Extra large</flux:heading>
<flux:heading level="2">H2 element</flux:heading>
<flux:heading accent>Accent color</flux:heading>
```

**Props**:
- `size`: base, lg, xl (default: base)
- `level`: 1, 2, 3, 4 (renders as div if not specified)
- `accent`: boolean

### Pagination
Navigate through data pages.

```php
<flux:pagination :paginator="$orders" />
```

### Separator
Visual content divider.

```php
<flux:separator />
<flux:separator text="or" />
<flux:separator variant="subtle" />
```

## JavaScript Integration

### Alpine.js Magic Methods
```javascript
// Modals
$flux.modal('name').show()
$flux.modal('name').close()
$flux.modals().close()

// Toasts
$flux.toast('Message')
$flux.toast({ heading: 'Title', text: 'Message', variant: 'success' })
```

### Window.Flux Global
```javascript
// Same methods available globally
Flux.modal('name').show()
Flux.toast('Message')
```

### Editor Extensions
```javascript
document.addEventListener('flux:editor', (e) => {
    // Register extensions
    e.detail.registerExtension(SomeExtension.configure({}))
    
    // Disable extensions
    e.detail.disableExtension('underline')
    
    // Access editor instance
    e.detail.init(({ editor }) => {
        editor.on('create', () => {})
        editor.on('update', () => {})
    })
})
```

## Customization

### Tailwind Overrides
Use `!` modifier for conflicts:
```php
<flux:button class="bg-zinc-800! hover:bg-zinc-700!">Custom</flux:button>
```

### Publishing Components
```bash
php artisan flux:publish
php artisan flux:publish --all
```

### Global Style Overrides
```css
[data-flux-button] {
    @apply bg-zinc-800 hover:bg-zinc-700;
}
```

## Common Patterns

### Form with Validation
```php
<form wire:submit="save">
    <div class="space-y-6">
        <flux:input wire:model="name" label="Name" required />
        <flux:textarea wire:model="description" label="Description" />
        <flux:select wire:model="category" label="Category">
            <flux:select.option value="tech">Technology</flux:select.option>
        </flux:select>
        <flux:checkbox wire:model="terms" label="I agree to terms" />
        <flux:button type="submit" variant="primary">Save</flux:button>
    </div>
</form>
```

### Data Table with Actions
```php
<flux:table :paginate="$items">
    <flux:table.columns>
        <flux:table.column sortable>Name</flux:table.column>
        <flux:table.column>Actions</flux:table.column>
    </flux:table.columns>
    <flux:table.rows>
        @foreach($items as $item)
            <flux:table.row>
                <flux:table.cell>{{ $item->name }}</flux:table.cell>
                <flux:table.cell>
                    <flux:dropdown>
                        <flux:button icon="ellipsis-horizontal" size="sm" />
                        <flux:menu>
                            <flux:menu.item wire:click="edit({{ $item->id }})">Edit</flux:menu.item>
                            <flux:menu.item variant="danger" wire:click="delete({{ $item->id }})">Delete</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
```

### Modal Confirmation
```php
<flux:button wire:click="$dispatch('confirm-delete')" variant="danger">Delete</flux:button>

<flux:modal name="confirm-delete" class="min-w-[22rem]">
    <div class="space-y-6">
        <flux:heading size="lg">Confirm Delete?</flux:heading>
        <flux:text>This action cannot be undone.</flux:text>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            <flux:button wire:click="delete" variant="danger">Delete</flux:button>
        </div>
    </div>
</flux:modal>
```