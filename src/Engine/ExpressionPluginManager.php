<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\ExpressionPluginManager.
 */

namespace Drupal\rules\Engine;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Plugin manager for all Rules expressions.
 *
 * @see \Drupal\rules\Engine\ExpressionInterface
 */
class ExpressionPluginManager extends DefaultPluginManager {

  /**
   * A map from class names to plugin ids.
   *
   * @var string[]
   */
  protected $classNamePluginIdMap;

  /**
   * {@inheritdoc}
   */
  public function __construct(\Traversable $namespaces, ModuleHandlerInterface $module_handler, $plugin_definition_annotation_name = 'Drupal\rules\Annotation\RulesExpression') {
    $this->alterInfo('rules_expression');
    parent::__construct('Plugin/RulesExpression', $namespaces, $module_handler, 'Drupal\rules\Engine\ExpressionInterface', $plugin_definition_annotation_name);
  }

  /**
   * Creates a new rule.
   *
   * @param \Drupal\rules\Engine\ExecutionStateDefinition $state_definition
   *   The definition of the expression's execution state.
   *
   * @return \Drupal\rules\Plugin\RulesExpression\RuleInterface
   *   The created rule.
   */
  public function createRule(ExecutionStateDefinition $state_definition = NULL) {
    return $this->createInstance('rules_rule', $state_definition ? $state_definition->toArray() : []);
  }

  /**
   * Creates a new action expression.
   *
   * @param string $id
   *   The action plugin id.
   *
   * @return \Drupal\rules\Core\RulesActionInterface;
   *   The created action.
   */
  public function createAction($id) {
    return $this->createInstance('rules_action', [
      'action_id' => $id,
    ]);
  }

  /**
   * Creates a new condition expression.
   *
   * @param string $id
   *   The condition plugin id.
   *
   * @return \Drupal\rules\Core\RulesConditionInterface
   *   The created condition.
   */
  public function createCondition($id) {
    return $this->createInstance('rules_condition', [
      'condition_id' => $id,
    ]);
  }

  /**
   * Creates a new 'and' condition container.
   *
   * @param \Drupal\rules\Engine\ExecutionStateDefinition $state_definition
   *   The definition of the expression's execution state.
   *
   * @return \Drupal\rules\Engine\ConditionExpressionContainerInterface
   *   The created 'and' condition container.
   */
  public function createAnd(ExecutionStateDefinition $state_definition = NULL) {
    return $this->createInstance('rules_and', $state_definition ? $state_definition->toArray() : []);
  }

  /**
   * Creates a new 'or' condition container.
   *
   * @param \Drupal\rules\Engine\ExecutionStateDefinition $state_definition
   *   The definition of the expression's execution state.
   *
   * @return \Drupal\rules\Engine\ConditionExpressionContainerInterface
   *   The created 'or' condition container.
   */
  public function createOr(ExecutionStateDefinition $state_definition = NULL) {
    return $this->createInstance('rules_or', $state_definition ? $state_definition->toArray() : []);
  }

}
