# Claude Code Instructions

## Core Principles
- Write Laravel 12+ idiomatic code
- Refer to claude-flux.md for Laravel 12 idiomatic examples
- Write clean and simple code
- Keep models simple
- Use Livewire unless told otherwise
- Use Actions pattern for business logic

## Front end
- For UI elements, use Flux UI.
- Always check claude-flux.md when writing Flux UI elements for the correct syntax and options.
- Ask when not sure about a Flux UI component.

## Actions
- Organize by domain: `app/Actions/User/UpdateUser.php`
- Naming: Verb + Resource (`CreateTodo`, `UpdateUser`)
- Primary method: `handle(array $attributes)`

## Livewire
- Direct route to component: `Route::get('/path', ComponentPage::class)`
- No `render` method in routes
- Use action-oriented naming: `EditQuotePage` not `QuoteEditPage`
- Page components: add "Page" suffix
- Organize by domain folders: `app/Livewire/Contacts/`
- Maintain a consistent method order: properties, mount, updated hooks, action methods, helper methods, render.
- Extract to dedicated form objects with `fromModel()` helpers

## External APIs
When creating an external API,
- Create a Service to call each external API, `app/Services/ServiceName/ServiceName.php`
- Create a Command for testing for the service