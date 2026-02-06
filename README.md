# Symfony AI Agent Best Practices Demo

This project is a demonstration of the best practices for using the `symfony/ai-agent` component in a Symfony 7.4 application, as inspired by the official Symfony AI initiative. It showcases how to build robust, testable, and maintainable AI features with clean architecture.

## Features

- **Dependency Injection:** Agents are configured in YAML and injected into services.
- **Type-Safe Tools:** Demonstrates the `#[AsTool]` attribute with strictly typed parameters using PHP Enums.
- **Dynamic Context Injection:** Shows how to use an `InputProcessor` to dynamically add context to an AI prompt.
- **Testability:** Includes a unit test using the `MockAgent` to test AI-integrated services without making real API calls.

## Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/mattleads/AIAgentSample.git
    cd AIAgentSample
    ```

2.  **Install dependencies using Composer:**
    ```bash
    composer install
    ```

## Configuration

1.  **Create a local environment file:**
    Copy the distributed environment file `.env` to `.env.local`. This file is ignored by Git and will store your secret API keys.
    ```bash
    cp .env .env.local
    ```

2.  **Set your OpenAI API Key:**
    Open the `.env.local` file and replace the placeholder value with your actual OpenAI API key.
    ```env
    # .env.local
    OPENAI_API_KEY=sk-proj-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    ```

## Usage Examples

This project includes several console commands to demonstrate the different features of the `symfony/ai-agent` component.

### 1. Basic Agent Interaction

This command tests the default AI agent configured in `config/packages/ai.yaml`.

**Command:**
```bash
php bin/console app:test-agent
```

**Expected Output:**
You will see a direct response from the LLM based on the prompt "Hello Symfony!".
```
Hello there! I'm a helpful Symfony assistant, ready to assist you with your technical questions. How can I help you today?
```

### 2. Using AI Tools (`OrderStatusTool`)

This command demonstrates how the AI can use a custom tool to perform an action. The agent will interpret the natural language prompt, identify the correct tool (`get_order_status`), and call it with the provided parameters.

**Command:**
```bash
php bin/console app:test-tool 12345 eu
```

**Expected Output:**
The agent will use the `OrderStatusTool` to retrieve the fictional order status.
```
Prompting agent: What is the status of order 12345 in the eu region?
Agent response:
Order 12345 in region eu is currently: SHIPPED
```

### 3. Dynamic Context (`UserContextProcessor`)

This command demonstrates how the `UserContextProcessor` can dynamically inject information into the prompt before it is sent to the AI. The command simulates a logged-in user to provide context.

**Command:**
```bash
php bin/console app:test-context
```

**Expected Output:**
The AI will respond with knowledge of the user's identity, which was provided by the context processor.
```
Simulated logging in user: cli.user@example.com

Prompting agent: Who am I?
Agent response:
You are cli.user@example.com (ID: 1).

Note: The UserContextProcessor added the user info to the AI prompt behind the scenes.
```

## Running Tests

This project includes a unit test for the `SupportAssistant` service that uses a `MockAgent` to avoid making real API calls.

To run the test suite, execute the following command:

```bash
vendor/bin/phpunit
```
